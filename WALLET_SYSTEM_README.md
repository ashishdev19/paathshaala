# Paathshaala Wallet System

Complete wallet system for teachers and students with transaction safety, withdraw management, and admin controls.

## Overview

The wallet system enables:
- **Students**: Top-up wallet balance and pay for courses using wallet
- **Teachers**: Receive earnings from course sales and request withdrawals
- **Admin**: Manage withdrawal requests, configure platform settings, view all transactions

## Database Structure

### Tables Created

1. **wallets** - User wallet balances
   - `user_id`, `balance`, `reserved_amount`, `currency`

2. **wallet_transactions** - Complete transaction ledger
   - Tracks all: credit, debit, hold, release, payout, refund, commission
   - Stores `balance_before` and `balance_after` for auditing

3. **withdraw_requests** - Teacher withdrawal requests
   - Status flow: pending → approved → paid (or rejected)
   - Stores payment details (bank, UPI, etc.)

4. **wallet_topups** - Student wallet top-up transactions
   - Integration with payment gateways (Razorpay, Stripe, Paytm)

5. **platform_settings** - System-wide wallet configuration
   - MIN_WITHDRAW_AMOUNT (default: ₹500)
   - PLATFORM_COMMISSION_PERCENT (default: 10%)
   - WITHDRAW_FEE_PERCENT (default: 2%)

## Installation & Setup

### 1. Run Migrations

```bash
php artisan migrate
```

This will create all wallet tables and seed default settings.

### 2. Create Wallets for Existing Users (Optional)

```bash
php artisan tinker
```

```php
// Create wallets for all existing users
\App\Models\User::all()->each(function($user) {
    $user->getOrCreateWallet();
});
```

### 3. Configure Payment Gateway

Update `.env` with your payment gateway credentials:

```env
# Razorpay
RAZORPAY_KEY=your_key_here
RAZORPAY_SECRET=your_secret_here

# Or Stripe
STRIPE_KEY=your_key_here
STRIPE_SECRET=your_secret_here
```

### 4. Configure Webhook URL

For wallet top-ups to work automatically, configure webhook URL in your payment gateway dashboard:

```
https://yourdomain.com/student/wallet/webhook
```

## Business Logic

### Student Wallet Flow

1. **Top-up**:
   - Student initiates top-up (minimum ₹100)
   - Redirected to payment gateway
   - On success: wallet credited, transaction recorded

2. **Course Purchase**:
   - At checkout, student can choose wallet payment
   - System validates sufficient balance
   - Amount deducted immediately
   - Teacher receives: `course_price - platform_commission`

### Teacher Wallet Flow

1. **Earning from Sales**:
   - When student purchases course: `earnings = price - (price * commission%)`
   - Amount credited to teacher wallet

2. **Withdrawal**:
   - Teacher requests withdrawal (min ₹500 default)
   - Withdrawal fee applied (2% default)
   - Admin approves/rejects
   - On approval → Admin processes payout → Marked as paid
   - Amount deducted from wallet on final payout

### Platform Commission

Default: 10% on all course sales
- Configurable via Admin → Wallet Settings
- Commission automatically deducted when teacher receives payment

## Usage Examples

### WalletService Usage

```php
use App\Services\WalletService;

$walletService = new WalletService();
$wallet = $user->getOrCreateWallet();

// Credit wallet
$walletService->credit(
    $wallet,
    1000,
    'Course sale earnings',
    ['course_id' => 1, 'enrollment_id' => 5]
);

// Debit wallet
$walletService->debit(
    $wallet,
    500,
    'Course purchase',
    ['course_id' => 2]
);

// Hold amount (for pending verification)
$walletService->hold($wallet, 200, 'Payment pending');

// Release held amount
$walletService->release($wallet, 200, 'Payment verified');
```

### Check Balance

```php
$user = Auth::user();
$wallet = $user->wallet;

// Available balance (excluding reserved)
$available = $wallet->available_balance;

// Total balance
$total = $wallet->balance;

// Reserved amount
$reserved = $wallet->reserved_amount;
```

## Admin Configuration

### Wallet Settings

Navigate to: **Admin Dashboard → Wallet → Settings**

Configurable parameters:
- **Minimum Withdraw Amount**: Default ₹500
- **Platform Commission**: Default 10%
- **Withdrawal Fee**: Default 2%
- **Enable Wallet Top-up**: ON/OFF

### Managing Withdrawals

1. **Pending Requests**:
   - Navigate to: Admin → Wallet → Withdraw Requests
   - Filter by status: pending/approved/paid/rejected

2. **Approve Withdrawal**:
   - Review request details
   - Click "Approve"
   - Process actual bank transfer/UPI
   - Enter UTR/Transaction reference
   - Click "Mark as Paid"

3. **Reject Withdrawal**:
   - Provide reason in admin note
   - Click "Reject"

## Routes

### Teacher Routes
- `GET /teacher/wallet` - Wallet dashboard
- `GET /teacher/wallet/withdraw` - Withdraw form
- `POST /teacher/wallet/withdraw-request` - Submit withdrawal
- `GET /teacher/wallet/withdraw-request/{id}` - View request status

### Student Routes
- `GET /student/wallet` - Wallet dashboard
- `GET /student/wallet/topup` - Top-up form
- `POST /student/wallet/topup` - Initiate top-up
- `POST /student/wallet/webhook` - Payment gateway webhook

### Admin Routes
- `GET /admin/wallet` - Wallet overview
- `GET /admin/wallet/withdraw-requests` - All requests
- `POST /admin/wallet/withdraw-requests/{id}/approve` - Approve
- `POST /admin/wallet/withdraw-requests/{id}/mark-paid` - Mark paid
- `POST /admin/wallet/withdraw-requests/{id}/reject` - Reject
- `GET /admin/wallet/settings` - Wallet settings
- `GET /admin/wallet/all-wallets` - View all wallets
- `POST /admin/wallet/user/{id}/adjust` - Manual adjustment

## Security Features

### Transaction Safety
- **DB Transactions**: All wallet operations wrapped in database transactions
- **Row Locking**: `lockForUpdate()` prevents race conditions
- **Balance Validation**: Checks before every debit
- **Audit Trail**: Every transaction logged with before/after balance

### Idempotency
- Webhook handlers check for duplicate processing
- Unique transaction references prevent double-processing

### Authorization
- Policy checks ensure users can only access their own wallet
- Admin-only access to approval/rejection actions
- Middleware-protected routes

## Testing Wallet Top-up (Without Gateway)

For development/testing, you can simulate successful top-up:

```php
// In Tinker
$student = \App\Models\User::find(1); // Student user
$topup = \App\Models\WalletTopup::create([
    'student_id' => $student->id,
    'amount' => 1000,
    'gateway' => 'test',
    'status' => 'pending'
]);

// Simulate success
$controller = app(\App\Http\Controllers\Student\WalletController::class);
$controller->handleTopupSuccess($topup->id, 'TEST_TXN_'.time());
```

## Notifications (To Be Implemented)

Planned notifications:
- [ ] Teacher: Wallet credited (course sale)
- [ ] Teacher: Withdrawal request approved/rejected/paid
- [ ] Student: Wallet topped up successfully
- [ ] Student: Payment deducted for course
- [ ] Admin: New withdrawal request pending

## Future Enhancements

- [ ] Bulk withdrawal processing
- [ ] Scheduled payouts (auto-approve)
- [ ] Wallet transaction export (CSV/Excel)
- [ ] Refund management interface
- [ ] Multi-currency support
- [ ] Analytics dashboard (earnings trends)

## Troubleshooting

### Issue: Insufficient balance error
**Solution**: Check `available_balance` vs `balance`. Reserved amount might be locked.

### Issue: Withdrawal request stuck in approved
**Solution**: Admin must manually mark as paid after processing bank transfer.

### Issue: Top-up webhook not received
**Solution**: 
1. Verify webhook URL in payment gateway dashboard
2. Check server logs for incoming requests
3. Ensure route is not protected by CSRF middleware

## Support

For issues or questions, contact the development team.

---

**Version**: 1.0  
**Last Updated**: November 24, 2025  
**Laravel Version**: 11.x

# Referral System Implementation - Complete Guide

## Overview

A comprehensive referral and invite system has been successfully implemented for both students and instructors. The system allows users to share referral codes, earn rewards, and track referral activity.

## How It Works

### Flow Diagram
```
User A (Referrer) → Shares Referral Code → User B (Referred) Signs Up
                                                    ↓
                                     User B gets ₹100 instant discount
                                                    ↓
                          User B makes first purchase (Enrollment)
                                                    ↓
                                User A gets ₹100 wallet credit
```

## Features Implemented

### 1. **User Registration with Referral Code**
- Optional referral code field added to registration form
- Auto-fills from URL parameter (?ref=CODE)
- Validates referral code before accepting
- Auto-generates unique referral code for every new user
- Creates referral record linking User A and User B

### 2. **Student Referral Dashboard** (`/student/referral`)
- Display unique referral code
- Shareable link with auto-fill capability
- Social sharing (WhatsApp, Email, Copy Link)
- Statistics: Total, Pending, Completed referrals, Total Earned
- Referral history with status tracking
- Pending discount alert if user was referred

### 3. **Instructor Referral Dashboard** (`/instructor/referral`)
- Same features as student dashboard
- Integration with wallet system
- Shows current wallet balance
- Earned credits added to instructor wallet
- Can use wallet credits for subscription payments

### 4. **Course Enrollment with Referral Discount**
- Automatic detection of pending referral discount
- Applies ₹100 discount to course price
- Can stack with other offers (e.g., NEWSTUDENT30)
- Marks discount as used after successful payment
- Credits referrer's wallet automatically

### 5. **Admin Referral Management** (`/admin/referral/settings`)
- Configure reward amounts
- Enable/disable referral system globally
- Set credit timing (immediate vs. after purchase)
- View referral statistics
- Monitor recent referral activity
- View all referrals (`/admin/referral/list`)

## Database Schema

### Tables Created

#### 1. `referral_codes`
```sql
- id
- user_id (FK to users)
- code (unique, e.g., "JOHN2026")
- is_active
- timestamps
```

#### 2. `referrals`
```sql
- id
- referrer_id (FK to users) - User A
- referred_id (FK to users) - User B
- referral_code
- referrer_credit (default: 100.00)
- referred_discount (default: 100.00)
- credit_applied (boolean)
- discount_applied (boolean)
- credit_applied_at
- discount_applied_at
- enrollment_id (FK to enrollments)
- timestamps
```

#### 3. `referral_settings`
```sql
- id
- key
- value
- type (string, integer, decimal, boolean)
- description
- timestamps
```

**Default Settings:**
- `referrer_credit_amount`: 100.00 (Amount given to User A)
- `referred_discount_amount`: 100.00 (Discount for User B)
- `credit_on_signup`: false (Credit after first purchase)
- `referral_enabled`: true (System enabled)

## File Structure

### Models
- `app/Models/ReferralCode.php` - Manages user referral codes
- `app/Models/Referral.php` - Tracks referral relationships
- `app/Models/ReferralSetting.php` - Stores system configuration
- `app/Models/User.php` - Extended with referral relationships

### Services
- `app/Services/ReferralService.php` - Core business logic
  - `processReferralSignup()` - Handle new signup with code
  - `creditReferrer()` - Add wallet credit to User A
  - `applyReferralDiscount()` - Mark discount as used by User B
  - `getAvailableDiscount()` - Check for pending discount
  - `getReferralStats()` - Get user statistics
  - `getReferralHistory()` - Get referral history

### Controllers
- `app/Http/Controllers/Auth/RegisteredUserController.php` - Registration with referral
- `app/Http/Controllers/EnrollmentController.php` - Checkout with referral discount
- `app/Http/Controllers/Student/ReferralController.php` - Student dashboard
- `app/Http/Controllers/Instructor/ReferralController.php` - Instructor dashboard
- `app/Http/Controllers/Admin/ReferralSettingController.php` - Admin management

### Views
- `resources/views/auth/register.blade.php` - Registration form with referral field
- `resources/views/student/referral/index.blade.php` - Student referral dashboard
- `resources/views/instructor/referral/index.blade.php` - Instructor referral dashboard
- `resources/views/admin/referral/settings.blade.php` - Admin settings page

### Routes
```php
// Student Routes
Route::get('/student/referral', [Student\ReferralController::class, 'index'])
    ->name('student.referral.index');

// Instructor Routes
Route::get('/instructor/referral', [Instructor\ReferralController::class, 'index'])
    ->name('instructor.referral.index');

// Admin Routes
Route::get('/admin/referral/settings', [Admin\ReferralSettingController::class, 'index'])
    ->name('admin.referral.settings');
Route::post('/admin/referral/settings', [Admin\ReferralSettingController::class, 'update'])
    ->name('admin.referral.settings.update');
Route::get('/admin/referral/list', [Admin\ReferralSettingController::class, 'referrals'])
    ->name('admin.referral.list');
```

## Usage Examples

### For Students

1. **Sharing Referral Code:**
   - Visit `/student/referral`
   - Copy unique referral code (e.g., "JOHN2026")
   - Share via WhatsApp, Email, or Copy Link
   - Friend uses code during registration

2. **Using a Referral Code:**
   - Register at `/register?ref=JOHN2026`
   - Code auto-fills in registration form
   - Get ₹100 instant discount on first course purchase
   - Discount automatically applied at checkout

3. **Earning Credits:**
   - When referred friend enrolls in a course
   - ₹100 credited to your wallet automatically
   - Use wallet credits for future purchases

### For Instructors

1. **Sharing Referral Code:**
   - Visit `/instructor/referral`
   - Copy unique referral code
   - Share with colleagues/students
   - Track referrals in dashboard

2. **Using Wallet Credits:**
   - Earned credits added to instructor wallet
   - View wallet at `/instructor/wallet`
   - Use for subscription renewals
   - Request withdrawal to bank account

### For Admins

1. **Configure System:**
   - Visit `/admin/referral/settings`
   - Set reward amounts
   - Choose credit timing
   - Enable/disable system

2. **Monitor Activity:**
   - View statistics on settings page
   - See recent referrals
   - Access full list at `/admin/referral/list`

## Technical Details

### Referral Code Generation
- Format: First 4 letters of name + 4 random digits
- Example: User "John Doe" → "JOHN2026"
- Always unique, validated against existing codes
- Fallback to timestamp-based code if conflicts

### Discount Application
1. Check for pending referral discount
2. Apply to course price first
3. Then apply other offers (NEWSTUDENT30)
4. Calculate final price
5. Mark referral as used after payment

### Wallet Credit Flow
1. User B signs up with referral code
2. Referral record created (credit_applied = false)
3. When User B makes first purchase:
   - `applyReferralDiscount()` called
   - Marks discount_applied = true
   - Triggers `creditReferrer()`
   - Adds ₹100 to User A's wallet
   - Creates wallet transaction record

### Security Features
- Prevents self-referral (can't use own code)
- Validates code exists and is active
- One-time discount per user
- Tracks usage to prevent fraud
- Admin can disable system globally

## Configuration Options

Edit in Admin Panel (`/admin/referral/settings`):

| Setting | Default | Description |
|---------|---------|-------------|
| Referrer Credit | ₹100.00 | Amount given to User A |
| Referred Discount | ₹100.00 | Discount for User B |
| Credit on Signup | false | When to credit (immediate vs. after purchase) |
| System Enabled | true | Enable/disable globally |

## Testing the System

### Test Scenario 1: Student Referral
```
1. Student A registers → Gets code "STUD1234"
2. Share link: /register?ref=STUD1234
3. Student B clicks link, registers
4. Student B enrolls in course → Gets ₹100 off
5. Student A receives ₹100 wallet credit
```

### Test Scenario 2: Instructor Referral
```
1. Instructor A registers → Gets code "INST5678"
2. Shares code with colleagues
3. Instructor B uses code during signup
4. Instructor B purchases subscription → Gets ₹100 off
5. Instructor A receives ₹100 wallet credit
6. Instructor A uses wallet for subscription renewal
```

## Future Enhancements (Optional)

- **Multi-tier Referrals**: Earn from referred user's referrals
- **Leaderboard**: Show top referrers
- **Custom Codes**: Allow users to choose their code
- **Expiry Dates**: Time-limited referral codes
- **Referral Tiers**: Different rewards based on referrer's role
- **Analytics Dashboard**: Detailed referral analytics
- **Email Notifications**: Auto-notify on referral events
- **Social Media Integration**: Direct share to Facebook, Twitter
- **Referral Contests**: Reward top referrers monthly

## Troubleshooting

### Issue: Referral code not applying
**Solution**: Check if:
- Code is active in database
- User hasn't already used a referral code
- System is enabled in admin settings

### Issue: Credits not appearing in wallet
**Solution**: Check if:
- Referred user completed their first purchase
- `credit_on_signup` setting matches expectation
- Wallet exists for referrer (auto-created if not)

### Issue: Discount not showing at checkout
**Solution**: Verify:
- User was registered with a valid referral code
- Discount hasn't already been used
- Referral record exists in database

## Support

For issues or questions:
1. Check admin referral settings
2. Review referral list for user
3. Check Laravel logs: `storage/logs/laravel.log`
4. Verify database records in `referrals` table

---

**Implementation Date**: January 30, 2026
**Status**: ✅ Complete and Production Ready

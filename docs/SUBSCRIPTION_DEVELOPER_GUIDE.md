# Teacher Subscription Module - Developer Guide

## Welcome! 👋

This guide helps you understand and work with the newly implemented teacher subscription system in Paathshaala.

## What is the Teacher Subscription Module?

A complete system allowing teachers to:
1. **Register** via public form
2. **Get approved** by admin with qualification review
3. **Subscribe** to one of 3 plans (Silver/Gold/Platinum)
4. **Manage** their subscription (upgrade, renew, cancel)
5. **Track** their subscription history

## Quick Start

### 1. Verify Everything is Working
```bash
cd c:\laragon\www\paathshaala
php verify_subscription_setup.php
```

Expected output:
```
✅ Found 3 subscription plans
✅ Table: subscription_plans
✅ Table: teacher_enquiries
✅ Table: teacher_subscriptions
✅ Table: teacher_subscription_history
```

### 2. See Available Routes
```bash
php artisan route:list | findstr subscription
```

### 3. Check Database Tables
```bash
php artisan tinker
> SubscriptionPlan::count()  // Should return 3
> TeacherEnquiry::count()    // Should return 0 (no applications yet)
```

## Module Structure

### The Database (Schema)

#### subscription_plans
Defines available subscription tiers:
```
id          | INT PRIMARY KEY
name        | VARCHAR (unique) - "Silver", "Gold", "Platinum"
slug        | VARCHAR (unique) - "silver", "gold", "platinum"
description | TEXT - Marketing description
price       | DECIMAL - Annual price in rupees
features    | JSON - Array of feature strings
max_students| INT - Maximum students allowed
max_courses | INT - Maximum courses allowed
is_active   | BOOLEAN - Whether plan is available
priority    | INT - Display order (1=highest)
created_at  | TIMESTAMP
updated_at  | TIMESTAMP
```

#### teacher_enquiries
Teachers applying to become instructors:
```
id                  | INT PRIMARY KEY
user_id             | INT (nullable) - Existing user applying
full_name           | VARCHAR - Applicant name
email               | VARCHAR (unique) - Application email
phone_number        | VARCHAR - Contact number
qualification       | VARCHAR - Educational qualification
experience          | INT - Years teaching experience
bio                 | TEXT - Professional biography
subject_expertise   | TEXT - Areas of expertise
plan_id             | INT (FK) - Preferred subscription plan
status              | ENUM: pending|approved|rejected
rejection_reason    | TEXT (nullable) - If rejected
reviewed_at         | TIMESTAMP (nullable) - Admin review time
reviewed_by         | INT (FK nullable) - Admin who reviewed
created_at          | TIMESTAMP
updated_at          | TIMESTAMP
```

#### teacher_subscriptions
Active teacher subscriptions:
```
id                  | INT PRIMARY KEY
user_id             | INT (FK) - Subscribed teacher
plan_id             | INT (FK) - Current subscription plan
teacher_enquiry_id  | INT (FK nullable) - Original enquiry
started_at          | TIMESTAMP - Subscription start
expires_at          | TIMESTAMP - Subscription end
status              | ENUM: active|expired|cancelled
paid_amount         | DECIMAL - Amount paid for current subscription
cancelled_at        | TIMESTAMP (nullable) - Cancellation time
cancellation_reason | TEXT (nullable) - Why cancelled
created_at          | TIMESTAMP
updated_at          | TIMESTAMP
```

#### teacher_subscription_history
Audit trail of all subscription changes:
```
id              | INT PRIMARY KEY
user_id         | INT (FK) - Teacher
from_plan_id    | INT (FK nullable) - Previous plan
to_plan_id      | INT (FK) - New/current plan
action          | ENUM: created|upgraded|downgraded|renewed|cancelled
amount_paid     | DECIMAL - Amount charged for this action
notes           | TEXT - Additional notes
action_date     | TIMESTAMP - When action occurred
created_by      | INT (FK nullable) - Admin who created
created_at      | TIMESTAMP
updated_at      | TIMESTAMP
```

### The Models (Business Logic)

#### SubscriptionPlan Model
Represents a subscription tier.

**Key Methods:**
```php
// Get all active plans
SubscriptionPlan::active()->get()

// Get ordered by priority
SubscriptionPlan::ordered()->get()

// Check if plan is available
$plan->is_active  // boolean

// Get features list
$plan->features_list  // array of strings
```

#### TeacherEnquiry Model
Represents a teacher's registration application.

**Key Methods:**
```php
// Get pending enquiries
TeacherEnquiry::pending()->get()

// Approve an enquiry
$enquiry->approve($adminUserId)

// Reject an enquiry
$enquiry->reject($reason, $adminUserId)

// Get enquiry status
$enquiry->status  // 'pending', 'approved', or 'rejected'
```

#### TeacherSubscription Model
Represents a teacher's active subscription.

**Key Methods:**
```php
// Check if subscription is active
$sub->isActive()  // returns boolean

// Check if expired
$sub->isExpired()  // returns boolean

// Days remaining
$sub->daysRemaining()  // returns integer

// Can upgrade to plan?
$sub->canUpgradeTo($newPlan)  // returns boolean

// Get upgrade cost (pro-rated)
$cost = $sub->getUpgradeCost($newPlan)  // returns float

// Perform upgrade
$sub->upgradeTo($newPlan, $paidAmount)

// Renew subscription
$sub->renew($paidAmount)  // extends 1 year

// Cancel subscription
$sub->cancel($reason)  // marks as cancelled
```

**Pro-rating Logic:**
When upgrading, the system calculates the exact cost for the remaining days:
- Get remaining days from now to expires_at
- Calculate daily cost of new plan: `newPrice / 365`
- Calculate pro-rated cost: `dailyCost × remainingDays`
- Deduct what was already paid for those days
- Charge only the difference

Example:
```
Scenario: Upgrade from Silver (₹5,000) to Gold (₹10,000) after 6 months
- Days remaining: 182 days
- Daily Gold cost: ₹10,000 / 365 = ₹27.40/day
- Pro-rated cost for remaining 182 days: ₹27.40 × 182 = ₹4,987.95
- Less what already paid for Silver (182 days): ₹2,493.15
- Charge: ₹4,987.95 - ₹2,493.15 = ₹2,494.80
```

#### TeacherSubscriptionHistory Model
Audit trail for compliance and analytics.

**Key Methods:**
```php
// Get history for a teacher
TeacherSubscriptionHistory::forUser($userId)->get()

// Get all upgrades
TeacherSubscriptionHistory::byAction('upgraded')->get()

// View action history
$record->action  // 'created', 'upgraded', 'downgraded', 'renewed', 'cancelled'
```

#### User Model (Updated)
Teachers using the system.

**New Relationships:**
```php
$user->currentSubscription      // Active subscription
$user->subscriptions()          // All subscriptions
$user->subscriptionHistory()    // History records
$user->teacherEnquiry          // Current enquiry
$user->teacherEnquiries()      // All enquiries
```

### The Controllers (API Layer)

#### Admin\SubscriptionPlanController
For administrators managing plans and approving teachers.

**Routes & Methods:**

Plan Management:
- `GET /admin/subscriptions/plans` → `plansIndex()`
  - Shows all plans with counts
- `GET /admin/subscriptions/plans/create` → `plansCreate()`
  - Shows create form
- `POST /admin/subscriptions/plans` → `plansStore()`
  - Saves new plan
- `GET /admin/subscriptions/plans/{id}/edit` → `plansEdit()`
  - Shows edit form
- `PUT /admin/subscriptions/plans/{id}` → `plansUpdate()`
  - Updates plan
- `DELETE /admin/subscriptions/plans/{id}` → `plansDestroy()`
  - Deletes plan (only if no active subscriptions)

Enquiry Management:
- `GET /admin/subscriptions/enquiries` → `enquiriesIndex()`
  - List all applications
- `GET /admin/subscriptions/enquiries/{id}` → `enquiriesShow()`
  - View application details
- `POST /admin/subscriptions/enquiries/{id}/approve` → `enquiriesApprove()`
  - Approve + create subscription
- `POST /admin/subscriptions/enquiries/{id}/reject` → `enquiriesReject()`
  - Reject with reason

#### Teacher\SubscriptionController
For teachers managing their subscription.

**Routes & Methods:**

- `GET /teacher/subscription` → `show()`
  - View current status
- `GET /teacher/subscription/upgrade` → `upgrade()`
  - Show available upgrades
- `POST /teacher/subscription/upgrade` → `processUpgrade()`
  - Process upgrade
- `GET /teacher/subscription/renew` → `renew()`
  - Show renewal option
- `POST /teacher/subscription/renew` → `processRenew()`
  - Process renewal
- `POST /teacher/subscription/cancel` → `cancel()`
  - Cancel subscription
- `GET /teacher/subscription/certificate` → `downloadCertificate()`
  - Download certificate (future feature)

#### Teacher\TeacherEnquiryController
For teacher registration and admin review.

**Routes & Methods:**

Public:
- `GET /teacher/register` → `create()`
  - Show registration form
- `POST /teacher/register` → `store()`
  - Submit enquiry
- `GET /teacher/enquiry-status` → `status()`
  - Check application status

Admin:
- `GET /admin/subscriptions/enquiries` → `index()`
  - List all enquiries
- `GET /admin/subscriptions/enquiries/{id}` → `show()`
  - View enquiry
- `POST /admin/subscriptions/enquiries/{id}/approve` → `approve()`
  - Approve enquiry
- `POST /admin/subscriptions/enquiries/{id}/reject` → `reject()`
  - Reject enquiry

## The Workflow

### Teacher Registration Flow

```
1. Teacher visits /teacher/register
   ↓
2. Fills form with details and selects plan
   ↓
3. System validates and creates TeacherEnquiry (status: pending)
   ↓
4. Admin receives notification (future feature)
   ↓
5. Admin reviews at /admin/subscriptions/enquiries
   ↓
6. Admin clicks Approve or Reject
   ↓
   If Approved:
   - Updates enquiry status to 'approved'
   - Creates TeacherSubscription (active, expires in 1 year)
   - Logs in TeacherSubscriptionHistory (action: 'created')
   - Teacher can now use subscription
   
   If Rejected:
   - Updates enquiry status to 'rejected'
   - Stores rejection reason
   - Teacher cannot reapply with same email
```

### Teacher Upgrade Flow

```
1. Teacher visits /teacher/subscription
   ↓
2. Views current subscription details
   ↓
3. Clicks "Upgrade to Gold"
   ↓
4. System shows pro-rated cost
   ↓
5. Teacher confirms
   ↓
6. System updates plan_id
   ↓
7. System extends expires_at appropriately
   ↓
8. Logs in history (action: 'upgraded')
   ↓
9. Teacher's new plan is active immediately
```

### Teacher Renewal Flow

```
1. Subscription expires (status remains 'active' but isExpired() = true)
   ↓
2. Teacher visits /teacher/subscription/renew
   ↓
3. System shows renewal cost (full year price)
   ↓
4. Teacher confirms
   ↓
5. System updates expires_at = now() + 1 year
   ↓
6. Logs in history (action: 'renewed')
   ↓
7. Subscription is active again
```

## Common Tasks

### Check if Teacher is Subscribed

```php
$user = auth()->user();

if ($user->currentSubscription && $user->currentSubscription->isActive()) {
    echo "Teacher is subscribed to: " . $user->currentSubscription->plan->name;
} else {
    echo "Teacher is not subscribed";
}
```

### Get Teacher's Remaining Days

```php
$sub = $user->currentSubscription;
echo "Subscription expires in " . $sub->daysRemaining() . " days";
```

### List All Active Teachers

```php
$activeTeachers = TeacherSubscription::active()
    ->with(['user', 'plan'])
    ->get();

foreach ($activeTeachers as $sub) {
    echo $sub->user->name . " - " . $sub->plan->name;
}
```

### Get Expiring Subscriptions (Next 30 Days)

```php
$expiring = TeacherSubscription::where('status', 'active')
    ->whereBetween('expires_at', [now(), now()->addDays(30)])
    ->get();

// Send renewal reminders
```

### Generate Revenue Report

```php
$totalRevenue = TeacherSubscriptionHistory::where('action', 'created')
    ->orWhere('action', 'upgraded')
    ->orWhere('action', 'renewed')
    ->sum('amount_paid');

echo "Total subscription revenue: ₹" . $totalRevenue;
```

## Important Rules

1. **Email must be unique** across both `teacher_enquiries` and `users` tables
2. **Price is annual** - subscription covers 365 days
3. **Pro-rating is daily-based** - not monthly
4. **Upgrade only** to higher tier (no downgrade yet)
5. **Admin approval required** before subscription activation
6. **Auto-expiry detection** - no manual status updates needed
7. **History logging** - every change is tracked
8. **Soft validation** - user-friendly error messages

## Troubleshooting

### "Teacher not found" after approval
**Check:**
- Is `user_id` set in `teacher_enquiries`?
- Does `teacher_subscriptions` record exist?
- Is `status` = 'active' and `expires_at` > now()?

### Upgrade cost seems wrong
**Check:**
- Are both plan prices correct?
- Is `expires_at` date in the future?
- Use formula: `(newPrice / 365) * daysRemaining - alreadyPaid`

### Enquiry not showing in list
**Check:**
- Is `status` one of: pending, approved, rejected?
- Does `plan_id` reference exist?
- Check timestamps (is it deleted or not?)

### Cannot delete plan
**Check:**
- Does plan have active subscriptions?
- Use: `Plan::find($id)->subscriptions()->where('status', 'active')->count()`

## Files You'll Work With

### Daily Tasks
- `routes/web.php` - Routes configuration
- `app/Http/Controllers/Admin/SubscriptionPlanController.php` - Admin logic
- `app/Http/Controllers/Teacher/SubscriptionController.php` - Teacher logic

### Adding Features
- `app/Models/TeacherSubscription.php` - Add business logic
- `database/migrations/` - Modify schema
- `app/Http/Requests/*.php` - Add validation

### Frontend
- `resources/views/admin/subscriptions/` - Admin UI (needs creation)
- `resources/views/teacher/subscription/` - Teacher UI (needs creation)

## Performance Notes

1. **Eager Load** relationships:
   ```php
   TeacherSubscription::with(['user', 'plan'])->get()
   ```

2. **Use Scopes** for common queries:
   ```php
   TeacherSubscription::active()->get()
   ```

3. **Cache plans** since they're used frequently:
   ```php
   Cache::remember('subscription_plans', 60*60, function() {
       return SubscriptionPlan::active()->get();
   });
   ```

4. **Index frequently** queried fields:
   - `user_id`, `status`, `expires_at` (already done in migrations)

## Next Steps

1. **Create Views** for admin and teacher interfaces
2. **Add Payment Gateway** integration (Razorpay/Stripe)
3. **Email Notifications** for approvals and expiry
4. **Analytics Dashboard** for revenue tracking
5. **API Endpoints** for mobile app

## Resources

- 📖 **Full Documentation:** SUBSCRIPTION_MODULE.md
- ⚡ **Quick Reference:** SUBSCRIPTION_QUICK_REFERENCE.md
- ✅ **Implementation Status:** SUBSCRIPTION_IMPLEMENTATION_STATUS.md
- 📊 **Completion Report:** SUBSCRIPTION_COMPLETION_REPORT.md
- 📁 **File Structure:** SUBSCRIPTION_FILE_STRUCTURE.md

## Questions?

All code includes comments explaining the logic. Look at:
1. Model methods for business rules
2. Controller methods for API logic
3. Migrations for database structure
4. Seeders for sample data

Good luck! 🚀

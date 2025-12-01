# Teacher Subscription System - Quick Reference

## Setup

### 1. Database Setup (Already Done)
```bash
# Run all migrations (including subscription tables)
php artisan migrate

# Seed default plans
php artisan db:seed --class=SubscriptionPlanSeeder
```

### 2. Models Usage

#### Check if teacher has active subscription
```php
$user = auth()->user();
$subscription = $user->currentSubscription;

if ($subscription && $subscription->isActive()) {
    echo "Teacher is subscribed to: " . $subscription->plan->name;
}
```

#### Get subscription details
```php
$sub = $user->currentSubscription;
echo "Expires in " . $sub->daysRemaining() . " days";
echo "Plan: " . $sub->plan->name;
echo "Max students: " . $sub->plan->max_students;
```

#### Create enquiry (Public)
```php
// In controller
TeacherEnquiry::create([
    'full_name' => $request->full_name,
    'email' => $request->email,
    'phone_number' => $request->phone_number,
    'qualification' => $request->qualification,
    'experience' => $request->experience,
    'bio' => $request->bio,
    'subject_expertise' => $request->subject_expertise,
    'plan_id' => $request->plan_id,
    'status' => 'pending',
]);
```

#### Admin approve enquiry
```php
$enquiry = TeacherEnquiry::find($enquiryId);
$enquiry->approve(auth()->id()); // Creates subscription

// Or manually:
$enquiry->update([
    'status' => 'approved',
    'reviewed_at' => now(),
    'reviewed_by' => auth()->id(),
]);

TeacherSubscription::create([
    'user_id' => $enquiry->user_id,
    'plan_id' => $enquiry->plan_id,
    'teacher_enquiry_id' => $enquiry->id,
    'started_at' => now(),
    'expires_at' => now()->addYear(),
    'status' => 'active',
    'paid_amount' => $enquiry->plan->price,
]);
```

#### Check upgrade cost
```php
$currentSub = $user->currentSubscription;
$newPlan = SubscriptionPlan::find($newPlanId);

if ($currentSub->canUpgradeTo($newPlan)) {
    $cost = $currentSub->getUpgradeCost($newPlan);
    echo "Pro-rated upgrade cost: ₹" . $cost;
}
```

#### Process upgrade
```php
$subscription->upgradeTo($newPlan, $paidAmount);

// Logged automatically to history
```

#### Get subscription history
```php
$history = $user->subscriptionHistory()
    ->latest()
    ->get();

foreach ($history as $record) {
    echo $record->action . " on " . $record->created_at;
}
```

## Routes

### Teacher Routes
```
GET  /teacher/subscription              Show current subscription
GET  /teacher/subscription/upgrade      Show upgrade options
POST /teacher/subscription/upgrade      Process upgrade
GET  /teacher/subscription/renew        Show renew option
POST /teacher/subscription/renew        Process renewal
POST /teacher/subscription/cancel       Cancel subscription
```

### Admin Routes
```
GET  /admin/subscriptions/plans         List all plans
POST /admin/subscriptions/plans         Create plan
GET  /admin/subscriptions/plans/{id}/edit Edit form
PUT  /admin/subscriptions/plans/{id}    Update plan
DEL  /admin/subscriptions/plans/{id}    Delete plan

GET  /admin/subscriptions/enquiries     List enquiries
GET  /admin/subscriptions/enquiries/{id} View enquiry
POST /admin/subscriptions/enquiries/{id}/approve Approve
POST /admin/subscriptions/enquiries/{id}/reject  Reject

GET  /admin/subscriptions/list          List subscriptions
GET  /admin/subscriptions/{id}          View subscription details
GET  /admin/subscriptions/history/all   View history
```

### Public Routes
```
GET  /teacher/register                  Registration form
POST /teacher/register                  Submit enquiry
GET  /teacher/enquiry-status            Check status
```

## Views to Create (Next Steps)

### Admin Views
```
resources/views/admin/subscriptions/
├── plans/
│   ├── index.blade.php          # List all plans with stats
│   ├── create.blade.php         # Create plan form
│   └── edit.blade.php           # Edit plan form
├── enquiries/
│   ├── index.blade.php          # List enquiries
│   └── show.blade.php           # Enquiry details + approve/reject
└── subscriptions/
    ├── index.blade.php          # List subscriptions
    └── show.blade.php           # Subscription details + history
```

### Teacher Views
```
resources/views/teacher/subscription/
├── show.blade.php               # Current subscription + options
├── upgrade.blade.php            # Select upgrade plan
└── renew.blade.php              # Confirm renewal

resources/views/teacher/enquiry/
├── create.blade.php             # Registration form
├── status.blade.php             # Enquiry status page
└── no-enquiry.blade.php         # No enquiry yet message
```

## Key Methods Reference

### SubscriptionPlan
```php
SubscriptionPlan::active()              // Get active plans
SubscriptionPlan::orderBy('priority')   // Ordered by priority
$plan->subscriptions()                  // Get all subscriptions
$plan->features_list                    // Get features array
```

### TeacherEnquiry
```php
TeacherEnquiry::pending()               // Get pending enquiries
TeacherEnquiry::approved()              // Get approved enquiries
$enquiry->approve($adminId)             // Approve enquiry
$enquiry->reject($reason, $adminId)     // Reject enquiry
```

### TeacherSubscription
```php
$sub->isActive()                        // Is active and not expired
$sub->isExpired()                       // Has subscription expired
$sub->daysRemaining()                   // Days until expiry
$sub->canUpgradeTo($plan)               // Can upgrade to plan?
$sub->getUpgradeCost($plan)             // Pro-rated upgrade cost
$sub->upgradeTo($plan, $amount)         // Process upgrade
$sub->renew($amount)                    // Renew for 1 year
$sub->cancel($reason)                   // Cancel subscription
```

### User (Teacher)
```php
$user->currentSubscription              // Active subscription
$user->subscriptions                    // All subscriptions
$user->subscriptionHistory()            // History records
$user->teacherEnquiry                   // Current enquiry
```

## SQL Queries

### Get all active teacher subscriptions
```sql
SELECT ts.*, sp.name, u.email 
FROM teacher_subscriptions ts
JOIN subscription_plans sp ON ts.plan_id = sp.id
JOIN users u ON ts.user_id = u.id
WHERE ts.status = 'active' AND ts.expires_at > NOW();
```

### Get teacher upgrade history
```sql
SELECT * FROM teacher_subscription_history
WHERE user_id = ? AND action = 'upgraded'
ORDER BY created_at DESC;
```

### Get expiring subscriptions (next 30 days)
```sql
SELECT * FROM teacher_subscriptions
WHERE status = 'active' 
AND expires_at BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY);
```

### Get pending enquiries count
```sql
SELECT COUNT(*) FROM teacher_enquiries WHERE status = 'pending';
```

## Business Rules

1. **Subscription must have:** user_id, plan_id, started_at, expires_at
2. **Status values:** active, expired, cancelled
3. **Enquiry status values:** pending, approved, rejected
4. **Price is annual:** 365 days of access
5. **Pro-rating:** Based on days remaining, not months
6. **Upgrade:** Only to higher tier (higher price)
7. **Auto-expire:** Via model `isExpired()` method
8. **History logging:** Every change is tracked
9. **Email unique:** In both teacher_enquiries and users table
10. **Admin review:** Required before subscription activation

## Troubleshooting

### Teacher can't see subscription after approval
Check:
- `teacher_subscriptions` table has record
- `status` = 'active' and `expires_at` > now()
- `currentSubscription()` relationship returns correct record

### Upgrade cost is wrong
Check:
- Both plans have correct prices
- `expires_at` date is set correctly
- Formula: `(newPrice / 365) * daysRemaining - amountAlreadyPaid`

### Enquiry not showing
Check:
- `status` field is 'pending', 'approved', or 'rejected'
- `plan_id` FK exists
- Timezone for `reviewed_at` timestamp

### History not logging
Check:
- `TeacherSubscriptionHistory::create()` called after changes
- `action` is valid: created, upgraded, downgraded, renewed, cancelled
- `to_plan_id` is set for most actions

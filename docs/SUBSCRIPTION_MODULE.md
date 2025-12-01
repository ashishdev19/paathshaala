# Teacher Subscription Module Documentation

## Overview

This module enables teachers to register and subscribe to different subscription tiers to teach courses on the Paathshaala platform. The system includes three subscription plans (Silver, Gold, Platinum) with different features and pricing.

## Architecture

### Database Schema

#### 1. subscription_plans
Stores subscription plan configurations managed by admins.

**Fields:**
- `id` - Plan identifier
- `name` - Unique plan name (e.g., "Silver", "Gold", "Platinum")
- `slug` - URL-friendly identifier (e.g., "silver")
- `description` - Plan description for display
- `price` - Annual subscription price (decimal)
- `features` - JSON array of plan features
- `max_students` - Maximum students allowed
- `max_courses` - Maximum courses allowed
- `is_active` - Whether plan is available for registration
- `priority` - Display order (1=highest priority)
- `timestamps` - created_at, updated_at

#### 2. teacher_enquiries
Tracks teacher registration applications awaiting approval.

**Fields:**
- `id` - Enquiry identifier
- `user_id` - Associated user (nullable for external applications)
- `full_name` - Applicant full name
- `email` - Unique email address
- `phone_number` - Contact number
- `qualification` - Educational qualification
- `experience` - Years of teaching experience
- `bio` - Professional biography
- `subject_expertise` - Areas of expertise
- `plan_id` - Requested subscription plan
- `status` - pending/approved/rejected
- `rejection_reason` - Reason if rejected
- `reviewed_at` - When admin reviewed
- `reviewed_by` - Admin who reviewed
- `timestamps`

#### 3. teacher_subscriptions
Tracks active and historical teacher subscriptions.

**Fields:**
- `id` - Subscription identifier
- `user_id` - Teacher user ID
- `plan_id` - Current subscription plan
- `teacher_enquiry_id` - Original enquiry (if from enquiry)
- `started_at` - Subscription start date
- `expires_at` - Subscription expiry date
- `status` - active/expired/cancelled
- `paid_amount` - Amount paid for this subscription
- `cancelled_at` - Cancellation date (if cancelled)
- `cancellation_reason` - Reason for cancellation
- `timestamps`

#### 4. teacher_subscription_history
Audit log for all subscription changes (upgrades, renewals, cancellations).

**Fields:**
- `id` - History record identifier
- `user_id` - Teacher user ID
- `from_plan_id` - Previous plan (for upgrades)
- `to_plan_id` - New/current plan
- `action` - created/upgraded/downgraded/renewed/cancelled
- `amount_paid` - Amount charged for this action
- `notes` - Additional notes (e.g., cancellation reason)
- `action_date` - When action occurred
- `created_by` - Admin who created (if admin action)
- `timestamps`

### Models

#### SubscriptionPlan
- **Relationships:**
  - `enquiries()` - Has many enquiries for this plan
  - `subscriptions()` - Has many subscriptions using this plan
- **Scopes:**
  - `active()` - Only active plans
  - `ordered()` - Ordered by priority
- **Methods:**
  - `getFeaturesListAttribute()` - Returns features array

#### TeacherEnquiry
- **Relationships:**
  - `user()` - Belongs to user
  - `plan()` - Belongs to subscription plan
  - `reviewer()` - Admin who reviewed
  - `subscription()` - Related subscription if approved
- **Scopes:**
  - `pending()` - Pending approval
  - `approved()` - Approved enquiries
  - `rejected()` - Rejected enquiries
- **Methods:**
  - `approve($reviewedBy)` - Approve enquiry
  - `reject($reason, $reviewedBy)` - Reject enquiry

#### TeacherSubscription
- **Relationships:**
  - `user()` - Belongs to user
  - `plan()` - Current subscription plan
  - `enquiry()` - Original enquiry if applicable
- **Scopes:**
  - `active()` - Currently active subscriptions
  - `expired()` - Expired subscriptions
  - `current()` - Current subscription for user
- **Key Methods:**
  - `isActive()` - Check if subscription is active and not expired
  - `isExpired()` - Check if subscription has expired
  - `daysRemaining()` - Days until expiry
  - `canUpgradeTo($plan)` - Check if upgrade to plan is possible
  - `getUpgradeCost($plan)` - Calculate pro-rated upgrade cost
  - `upgradeTo($plan, $paidAmount)` - Process upgrade with history
  - `renew($paidAmount)` - Renew subscription for another year
  - `cancel($reason)` - Cancel subscription

#### TeacherSubscriptionHistory
- **Relationships:**
  - `user()` - Related user
  - `fromPlan()` - Source plan (if upgrade)
  - `toPlan()` - Destination plan
  - `createdBy()` - Admin who created record
- **Scopes:**
  - `forUser($userId)` - Subscriptions for specific user
  - `byAction($action)` - Subscriptions by action type

#### User (Updated)
Added relationships:
- `teacherEnquiry()` - Current teacher enquiry
- `teacherEnquiries()` - All enquiries
- `subscriptions()` - All subscriptions
- `currentSubscription()` - Active subscription
- `subscriptionHistory()` - Subscription history

### Controllers

#### Admin\SubscriptionPlanController
Admin panel for subscription management.

**Methods:**
- **Plan Management:**
  - `plansIndex()` - List all plans with stats
  - `plansCreate()` - Show create form
  - `plansStore()` - Save new plan
  - `plansEdit()` - Show edit form
  - `plansUpdate()` - Update plan details
  - `plansDestroy()` - Delete plan (only if no active subscriptions)

- **Enquiry Management:**
  - `enquiriesIndex()` - List all enquiries with stats
  - `enquiriesShow()` - View enquiry details
  - `enquiriesApprove()` - Approve enquiry and create subscription
  - `enquiriesReject()` - Reject enquiry with reason

- **Subscription Management:**
  - `subscriptionsIndex()` - List all subscriptions
  - `subscriptionsShow()` - View subscription details with history

- **History:**
  - `historyIndex()` - View all subscription history

#### Teacher\SubscriptionController
Teacher dashboard for subscription management.

**Methods:**
- `show()` - View current subscription status and options
- `upgrade()` - Show available higher tier plans
- `processUpgrade()` - Process plan upgrade with pro-rating
- `renew()` - Show renewal option for expired subscriptions
- `processRenew()` - Renew subscription for another year
- `cancel()` - Cancel active subscription
- `downloadCertificate()` - Download subscription certificate (future feature)

#### Teacher\TeacherEnquiryController
Teacher registration and enquiry management.

**Methods:**
- `create()` - Show public registration form
- `store()` - Submit registration enquiry
- `status()` - Check enquiry status
- Admin methods: `index()`, `show()`, `approve()`, `reject()`

### Routes

#### Admin Routes
```
/admin/subscriptions/plans              - List plans
/admin/subscriptions/plans/create       - Create plan form
/admin/subscriptions/plans              - Store plan
/admin/subscriptions/plans/{plan}/edit  - Edit plan form
/admin/subscriptions/plans/{plan}       - Update plan
/admin/subscriptions/plans/{plan}       - Delete plan

/admin/subscriptions/enquiries          - List enquiries
/admin/subscriptions/enquiries/{e}      - View enquiry
/admin/subscriptions/enquiries/{e}/approve - Approve
/admin/subscriptions/enquiries/{e}/reject  - Reject

/admin/subscriptions/list               - List all subscriptions
/admin/subscriptions/{sub}              - View subscription details
/admin/subscriptions/history/all        - View history log
```

#### Teacher Routes
```
/teacher/subscription                   - View current subscription
/teacher/subscription/upgrade           - Upgrade form
/teacher/subscription/upgrade (POST)    - Process upgrade
/teacher/subscription/renew             - Renew form
/teacher/subscription/renew (POST)      - Process renewal
/teacher/subscription/cancel (POST)     - Cancel subscription
/teacher/subscription/certificate       - Download certificate
```

#### Public Routes
```
/teacher/register                       - Teacher registration form
/teacher/register (POST)                - Submit enquiry
/teacher/enquiry-status                 - Check enquiry status
```

### Validation Rules

#### CreateTeacherEnquiryRequest
- `full_name` - Required, string, max 255
- `email` - Required, email, unique in teacher_enquiries and users
- `phone_number` - Required, string, max 20, valid phone format
- `qualification` - Required, string, max 255
- `experience` - Required, integer, 0-70 years
- `bio` - Required, string, 50-1000 chars
- `subject_expertise` - Required, string, 10-500 chars
- `plan_id` - Required, exists in subscription_plans
- `agree_terms` - Must be accepted

#### UpdateSubscriptionPlanRequest
- `name` - Required, unique (except current)
- `slug` - Required, unique (except current)
- `description` - Optional, string
- `price` - Required, decimal, min 0
- `features` - Optional, valid JSON
- `max_students` - Optional, integer, min 0
- `max_courses` - Optional, integer, min 0
- `priority` - Optional, integer, 0-100
- `is_active` - Boolean

## Default Subscription Plans

### Silver (₹5,000/year)
- **Priority:** 3 (entry-level)
- **Max Students:** 100
- **Max Courses:** 5
- **Features:**
  - Online class hosting
  - Email support
  - Basic analytics
  - Certificate generation

### Gold (₹10,000/year)
- **Priority:** 2 (popular)
- **Max Students:** 500
- **Max Courses:** 20
- **Features:**
  - All Silver features
  - Priority email support
  - Advanced analytics
  - Custom course branding
  - Video recording & playback
  - Student progress tracking

### Platinum (₹20,000/year)
- **Priority:** 1 (premium)
- **Max Students:** 2000
- **Max Courses:** Unlimited
- **Features:**
  - All Gold features
  - 24/7 priority support
  - Dedicated account manager
  - API access
  - White-label options
  - Team collaboration tools
  - Revenue sharing option

## Key Features

### Pro-rated Upgrade Cost
When a teacher upgrades from one plan to another mid-year, the system calculates a pro-rated cost based on:
- Days remaining in current subscription
- Price difference between plans

**Formula:**
```
Daily cost of new plan = New plan price / 365
Days remaining = (Expiry date - Today) days
Pro-rated cost = Daily cost × Days remaining
Amount to charge = Pro-rated cost - Amount already paid (pro-rated)
```

### Subscription Lifecycle
1. **Enquiry:** Teacher submits registration form
2. **Admin Review:** Admin approves or rejects
3. **Active:** Subscription runs from start_at to expires_at
4. **Expired:** Auto-marked when expires_at is reached
5. **Renewal:** Teacher can renew for another year
6. **Upgrade/Downgrade:** Change plans mid-year
7. **Cancelled:** Teacher explicitly cancels subscription

### Automatic Expiry Detection
The system automatically checks if a subscription is expired:
- `isExpired()` returns true if expires_at <= now()
- Admin dashboard shows expired subscriptions
- Teachers cannot access features if subscription is expired

### History Tracking
All subscription changes are logged in teacher_subscription_history with:
- Action type (created, upgraded, downgraded, renewed, cancelled)
- Amount paid for that action
- Timestamps and user references
- Notes (e.g., cancellation reason)

## Business Logic

### Approval Flow
1. Teacher submits enquiry with chosen plan
2. Admin reviews qualifications and experience
3. Admin approves/rejects
4. If approved:
   - Create teacher_subscriptions record
   - Set started_at = now(), expires_at = now + 1 year
   - Log in teacher_subscription_history (action: 'created')
5. If rejected:
   - Update status to rejected
   - Store rejection_reason
   - Notify teacher

### Upgrade Logic
1. Teacher selects higher-tier plan
2. System calculates pro-rated cost
3. If teacher confirms payment:
   - Update plan_id in subscriptions
   - Extend expires_at appropriately
   - Log in history (action: 'upgraded')
   - Notify teacher
4. If payment fails: Subscription unchanged

### Renewal Logic
1. Teacher initiates renewal for expired subscription
2. System charges full annual price
3. If payment successful:
   - Update expires_at = now() + 1 year
   - Update status = 'active'
   - Log in history (action: 'renewed')
   - Notify teacher
4. If failed: Subscription remains expired

## Future Enhancements

- [ ] Payment gateway integration (Razorpay/Stripe)
- [ ] Email notifications for approvals/rejections/expiry warnings
- [ ] Subscription gift codes/coupons
- [ ] Admin analytics dashboard
- [ ] Auto-renewal option
- [ ] Downgrade with pro-rated refund
- [ ] Bulk teacher import
- [ ] Subscription insurance (pause feature)
- [ ] Team accounts (multiple teachers under one subscription)

## Security

- Admin middleware protects all admin endpoints
- Auth middleware protects teacher endpoints
- Email uniqueness enforced across both tables
- Foreign key constraints prevent orphaned records
- Cascade deletes maintain data integrity
- Role-based access control via Spatie permissions

## Testing

To test the subscription system:

1. **Seed plans:** `php artisan db:seed --class=SubscriptionPlanSeeder`

2. **View plans:**
   - `/admin/subscriptions/plans` (admin only)

3. **Register as teacher:**
   - `/teacher/register`
   - Fill enquiry form with plan selection

4. **Admin approval:**
   - `/admin/subscriptions/enquiries`
   - Review and approve/reject

5. **Teacher dashboard:**
   - `/teacher/subscription`
   - View status and manage subscription

## API Endpoints (Future)

- `GET /api/subscription-plans` - List active plans
- `GET /api/subscription-plans/{plan}` - Get plan details
- `POST /api/teacher-enquiry` - Submit enquiry
- `GET /api/teacher/subscription` - Get current subscription
- `POST /api/teacher/subscription/upgrade` - Request upgrade
- `POST /api/teacher/subscription/renew` - Renew subscription

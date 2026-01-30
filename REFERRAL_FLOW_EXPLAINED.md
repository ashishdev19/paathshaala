# Complete Referral Flow - Step by Step

## 📋 Overview

This document explains exactly how the referral system works and where students can see and use their referral benefits.

---

## 🔄 Complete Flow: Student A Refers Student B

### Step 1: Student A Creates Account
1. **Student A** registers at `/register`
2. System automatically generates a unique referral code (e.g., "STUD1234")
3. Student A can view their code at `/student/referral`

### Step 2: Student A Shares Referral Code
**Where to find the code:**
- Go to Student Dashboard → Click **"Referral Program"** in sidebar
- Page shows:
  - ✅ Your unique referral code in large font
  - ✅ Share buttons (WhatsApp, Email, Copy Link)
  - ✅ Shareable URL: `https://yoursite.com/register?ref=STUD1234`

### Step 3: Student B Uses the Referral Code
**Student B signs up in one of two ways:**

**Option A: Click the shared link**
```
https://yoursite.com/register?ref=STUD1234
```
- Referral code auto-fills in registration form
- Student B completes registration
- ✅ System records that Student B was referred by Student A

**Option B: Manually enter code**
- Student B goes to `/register`
- Fills out form
- Enters `STUD1234` in the "Referral Code" field (optional field)
- Completes registration
- ✅ System records the referral

### Step 4: What Student B Gets (IMMEDIATE)
**Right after registration, Student B gets:**

✅ **₹100 Discount Credit** (default amount, configurable by admin)

**Where Student B can see this:**
1. **Go to `/student/referral`**
   - Green alert box at top shows: "You Have a Referral Discount!"
   - Amount shown: "₹100 referral discount available"
   - Message: "This will be automatically applied to your next course purchase"

2. **When enrolling in a course:**
   - Go to any course → Click "Enroll Now"
   - At checkout page (`/enrollment/checkout/{course}`)
   - Purple banner at top: "Referral Discount Applied! 🎉"
   - Shows: "You're getting ₹100 off this course"
   - In price breakdown:
     ```
     Course Price:        ₹5,000
     Referral Discount:   -₹100
     Offer Discount:      -₹1,500 (if applicable)
     -------------------------
     Total Amount:        ₹3,400
     ```

### Step 5: Student B Makes First Purchase
**When Student B enrolls in any course:**
1. Goes to course page
2. Clicks "Enroll Now"
3. At checkout, sees referral discount already applied
4. Completes payment
5. ✅ System marks: Student B's discount as "USED"
6. ✅ System triggers: Credit Student A's wallet

### Step 6: What Student A Gets (AFTER Student B's Purchase)
**Student A receives ₹100 wallet credit**

**Where Student A can see this:**

1. **Referral Dashboard** (`/student/referral`):
   - **Blue "Wallet Credits" box** shows:
     - "Your Wallet Credits"
     - Amount: "₹100.00 in wallet credits"
     - "Earned from referrals"
   
   - **Statistics cards** show:
     - Total Referrals: 1
     - Pending: 0
     - Completed: 1
     - **Total Earned: ₹100.00** ← This updates!

2. **Referral History Table**:
   - Shows Student B's name
   - Status: "Completed" (green badge)
   - Your Credit: "₹100.00" (green, bold)
   - Their Discount: "₹100.00"

3. **Wallet Transactions** (if checking wallet):
   - Transaction: "Referral bonus - [Student B Name] joined using your code"
   - Amount: +₹100.00

---

## 💰 Where to Use Wallet Credits (For Student A)

Currently, wallet credits earned from referrals can be:

### ✅ Available Uses:
1. **Future Course Purchases** - Credits can offset course costs
2. **View Balance** - Check at `/student/referral` in blue Wallet Credits box

### 🔄 Planned Features (Future):
- Apply wallet credits at checkout automatically
- Withdraw to bank account (like instructors)
- Gift credits to other students
- Use for certificates or special content

---

## 📊 Visual Reference - Where Students See Everything

### Student B (Referred User) - Visual Journey

#### 1. At Registration Page
```
┌─────────────────────────────────────┐
│  Register                           │
│                                     │
│  Name: [John Doe]                  │
│  Email: [john@example.com]         │
│  Password: [••••••••]              │
│                                     │
│  Referral Code (Optional)          │
│  [STUD1234] ← Auto-filled from link│
│  ℹ️ Get instant ₹100 discount!     │
│                                     │
│  [Create Account]                  │
└─────────────────────────────────────┘
```

#### 2. At Referral Dashboard (`/student/referral`)
```
┌─────────────────────────────────────┐
│  🎁 Referral Program                │
├─────────────────────────────────────┤
│                                     │
│  ✅ You Have a Referral Discount!  │
│  You have ₹100 referral discount   │
│  available! This will be           │
│  automatically applied to your     │
│  next course purchase.             │
│  [Browse Courses]                  │
│                                     │
├─────────────────────────────────────┤
│  Your Referral Code: JOHN4567      │
│  (Share with others to earn!)      │
└─────────────────────────────────────┘
```

#### 3. At Checkout Page
```
┌─────────────────────────────────────┐
│  🎉 Referral Discount Applied!     │
│  You're getting ₹100 off this      │
│  course because you used a         │
│  referral code!                    │
└─────────────────────────────────────┘

Order Summary
─────────────────
Course Price:         ₹5,000
🎁 Referral Discount: -₹100  ← SHOWN HERE
Offer Discount:       -₹1,500
─────────────────────────────
Total Amount:         ₹3,400
```

### Student A (Referrer) - Visual Journey

#### At Referral Dashboard (`/student/referral`)
```
┌─────────────────────────────────────┐
│  💰 Your Wallet Credits             │
│  You have ₹100.00 in wallet credits│
│  Earned from referrals              │
│  ✓ Course purchases                │
│  ✓ Future enrollments              │
└─────────────────────────────────────┘

Statistics
┌──────┬──────┬──────┬──────────┐
│Total │Pend. │Comp. │  Earned  │
│  1   │  0   │  1   │ ₹100.00  │← Updates!
└──────┴──────┴──────┴──────────┘

Referral History
┌───────────┬────────┬──────────┬──────────┐
│ User      │ Date   │ Status   │ Credit   │
├───────────┼────────┼──────────┼──────────┤
│ John Doe  │ Jan 30 │✓Complete │ ₹100.00  │← Shows here
└───────────┴────────┴──────────┴──────────┘
```

---

## 🎯 Quick Reference - Where to Check

| **What**                    | **Where to Find It**                          |
|----------------------------|----------------------------------------------|
| **My referral code**        | `/student/referral` - Big code in teal box  |
| **My pending discount** (B) | `/student/referral` - Green alert at top    |
| **Discount at checkout** (B)| `/enrollment/checkout` - Purple banner      |
| **My wallet credits** (A)   | `/student/referral` - Blue wallet box       |
| **My earnings** (A)         | `/student/referral` - Statistics cards      |
| **Referral history** (A)    | `/student/referral` - Table at bottom       |
| **Share my code** (A)       | `/student/referral` - Share buttons         |

---

## ⚙️ System Settings (Admin Only)

Admins can configure at `/admin/referral/settings`:

- **Referrer Credit Amount**: How much Student A gets (default: ₹100)
- **Referred Discount Amount**: How much Student B gets (default: ₹100)
- **Credit Timing**: 
  - Immediate on signup ❌ (Can lead to abuse)
  - After first purchase ✅ (Recommended - Default)
- **Enable/Disable System**: Toggle entire feature on/off

---

## 🐛 Troubleshooting

### "I don't see my referral discount"
**Check:**
1. Did you use a referral code during registration?
2. Go to `/student/referral` - Is there a green alert box?
3. Have you already used the discount? (Only works once)

### "My friend enrolled but I didn't get credits"
**Check:**
1. Did your friend use YOUR referral code?
2. Did your friend complete their FIRST purchase?
3. Go to `/student/referral` - Check "Referral History" table
4. Look for your friend's name with status "Completed"

### "Where can I use my wallet credits?"
**Currently:**
- View balance at `/student/referral`
- Credits stored in your wallet for future use
- System tracks all earnings in "Total Earned" stat

**Coming Soon:**
- Apply at checkout automatically
- Withdraw to bank account

---

## 📈 Example Scenario

**Real-World Example:**

1. **Sarah (Student A)** registers → Gets code "SARA8901"
2. Sarah shares with friend Mike via WhatsApp
3. **Mike (Student B)** clicks link → Code auto-fills → Registers
4. Mike goes to `/student/referral` → Sees green box: "₹100 discount available"
5. Mike enrolls in "Advanced Python Course" (₹5,000)
6. At checkout, Mike sees:
   - Course: ₹5,000
   - Referral Discount: -₹100
   - Total: ₹4,900
7. Mike completes payment
8. **Sarah immediately gets:**
   - Email/notification: "You earned ₹100!"
   - Wallet credited: +₹100
   - `/student/referral` shows: "Total Earned: ₹100.00"
   - History table shows: Mike | ✓ Complete | ₹100.00

---

**Last Updated:** January 30, 2026  
**Version:** 1.0  
**Status:** ✅ Fully Implemented and Working

# Admin Referral Management Guide

## Overview
Admins can now manage referral campaigns based on occasions, festivals, or special events through the Admin Panel.

## Accessing Referral Settings
1. Log in as Admin
2. Navigate to **Admin Panel** → **Referral** → **Settings**

## Managing Referral Campaigns

### Setting Up an Occasion-Based Campaign

#### Example: Diwali Special Campaign
1. **Campaign Name**: "Diwali Special 2026"
2. **Valid From**: 2026-10-20
3. **Valid Until**: 2026-11-05
4. **Referrer Credit**: ₹200 (double the usual amount!)
5. **Referred Discount**: ₹150 (better discount for new users)
6. **Enable System**: ✓ Checked

Click "Save Settings" to activate.

#### Example: New Year Offer
1. **Campaign Name**: "New Year Welcome 2027"
2. **Valid From**: 2026-12-25
3. **Valid Until**: 2027-01-15
4. **Referrer Credit**: ₹150
5. **Referred Discount**: ₹100
6. **Enable System**: ✓ Checked

### Campaign Settings Explained

#### Campaign Name
- Give your campaign a memorable name
- Examples:
  - "Diwali Dhamaka"
  - "Summer Special"
  - "Independence Day Offer"
  - "Back to School Campaign"
  - "Black Friday Bonanza"

#### Valid From / Valid Until
- **Optional fields** - leave blank for always-active campaigns
- Set specific date ranges for seasonal promotions
- System automatically validates:
  - Referrals only work DURING the campaign period
  - Outside dates = referral code won't work

#### Referrer Credit Amount (₹)
- Money added to User A's wallet when User B makes first purchase
- Standard: ₹100
- Special occasions: ₹150-₹500

#### Referred Discount Amount (₹)
- Instant discount for User B on first course
- Standard: ₹100
- Special occasions: ₹100-₹300

#### Credit Timing
- **Immediately on signup**: User A gets credit right away (risky)
- **After first purchase**: User A gets credit only after User B buys (recommended)

#### Enable/Disable System
- Toggle entire referral system on/off
- Useful for maintenance or to pause campaigns

## Example Campaign Scenarios

### 1. Year-Round Standard Campaign
```
Campaign Name: [Leave blank or "Standard Referral"]
Valid From: [Blank]
Valid Until: [Blank]
Referrer Credit: ₹100
Referred Discount: ₹100
Credit Timing: After first purchase
Enabled: ✓
```

### 2. Festival Mega Campaign
```
Campaign Name: "Holi Mega Bonanza"
Valid From: 2026-03-10
Valid Until: 2026-03-20
Referrer Credit: ₹300
Referred Discount: ₹200
Credit Timing: After first purchase
Enabled: ✓
```

### 3. Limited Time Flash Campaign
```
Campaign Name: "Weekend Flash Sale"
Valid From: 2026-02-01
Valid Until: 2026-02-02
Referrer Credit: ₹500
Referred Discount: ₹250
Credit Timing: After first purchase
Enabled: ✓
```

## Dashboard Statistics

The admin panel shows:
- **Total Referrals**: All-time referral count
- **Pending**: Users who registered but haven't purchased yet
- **Completed**: Referrals where discounts were used
- **Credits Given**: Total ₹ paid to referrers
- **Discounts Given**: Total ₹ discounted to referred users

## Student Experience

When a campaign is active:
1. Students see campaign name on their referral page
2. Referral amount updates automatically
3. Example: "Share this code with friends to earn ₹200 for each signup!" (during Diwali campaign)

## Best Practices

### 1. Plan Ahead
- Set up campaigns 1 week before the occasion
- Test with a small amount first

### 2. Seasonal Campaigns
- **Diwali**: Oct-Nov
- **New Year**: Dec-Jan
- **Holi**: Mar
- **Independence Day**: Aug
- **Dussehra**: Sep-Oct

### 3. Marketing Ideas
- Announce campaigns via email
- Post on social media
- In-app notifications to students

### 4. Budget Control
- Monitor "Credits Given" and "Discounts Given" statistics
- Set reasonable amounts based on course prices
- Example: If average course is ₹500, don't give ₹500 discount!

## Monitoring Campaign Performance

### View All Referrals
Click "View All" button → See complete referral list with:
- Who referred whom
- When they joined
- Discount status
- Credit status

### Recent Activity
Main settings page shows last 10 referrals in real-time

## Troubleshooting

### Campaign Not Working
1. Check "Enable Referral System" is ✓ checked
2. Verify dates - make sure current date is between Valid From and Valid Until
3. Check if amounts are > 0

### Too Many Referrals
1. Reduce referrer credit amount
2. Reduce referred discount amount
3. Temporarily disable system

## Security Notes

- Only Super Admin and Admin roles can access these settings
- All changes are logged
- Campaign dates prevent abuse of expired offers

## Questions?

Contact development team or check system logs at `storage/logs/laravel.log`

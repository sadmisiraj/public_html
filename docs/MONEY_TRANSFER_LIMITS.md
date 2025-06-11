# Money Transfer Limits Feature

## Overview

The Money Transfer Limits feature allows administrators to control how frequently users can transfer money to other users. This feature helps prevent abuse and provides better control over the money transfer functionality.

## Features

- **Enable/Disable Limits**: Administrators can enable or disable money transfer limits
- **Multiple Limit Types**: 
  - Daily limits (e.g., 3 transfers per day)
  - Weekly limits (e.g., 10 transfers per week)
  - Custom period limits (e.g., 5 transfers every 14 days)
- **Configurable Transfer Count**: Set how many transfers are allowed in each period
- **Automatic Reset**: Limits automatically reset based on the configured period
- **User-Friendly Messages**: Clear error messages when limits are exceeded
- **Real-time Limit Display**: Users can see their remaining transfers

## Admin Configuration

### Accessing the Settings

1. Navigate to **Security Settings** in the admin panel
2. Go to **Payout Settings** page (`/security/security/payout`)
3. Look for the "Money Transfer Limits" section

### Configuration Options

#### Enable Money Transfer Limits
- **Toggle**: Enable/disable the entire feature
- **Default**: Disabled

#### Limit Type
- **Daily**: Users can transfer X times per day
- **Weekly**: Users can transfer X times per week  
- **Custom Days**: Users can transfer X times every Y days

#### Number of Transfers Allowed
- **Range**: 1-100 transfers
- **Default**: 1 transfer

#### Number of Days (Custom Days only)
- **Range**: 1-365 days
- **Default**: 1 day
- **Note**: Only shown when "Custom Days" is selected

### Examples

1. **Daily Limit**: 
   - Type: Daily
   - Count: 5
   - Result: Users can transfer 5 times per day

2. **Weekly Limit**:
   - Type: Weekly
   - Count: 15
   - Result: Users can transfer 15 times per week

3. **Custom Period**:
   - Type: Custom Days
   - Count: 3
   - Days: 7
   - Result: Users can transfer 3 times every 7 days

## User Experience

### Limit Information Display

When limits are enabled, users will see:
- Current limit information on the money transfer page
- Remaining transfers allowed
- Next reset date/time

### When Limits Are Exceeded

Users will see error messages like:
- "You have exhausted your daily transfer limit of 3 transfer(s). Please wait 8 hours to make your next transaction."
- "You have exhausted your weekly transfer limit of 10 transfer(s). Please wait 2 days to make your next transaction."
- "You have exhausted your transfer limit of 5 transfer(s) for every 14 day(s). Please wait 5 days to make your next transaction."

### Transfer Button State

- **Enabled**: When transfers are allowed
- **Disabled**: When limit is reached (button text changes to "Transfer Limit Reached")

## Technical Implementation

### Database Changes

New columns added to `basic_controls` table:
- `money_transfer_limit_enabled` (boolean)
- `money_transfer_limit_type` (string: 'daily', 'weekly', 'custom_days')
- `money_transfer_limit_count` (integer: 1-100)
- `money_transfer_limit_days` (integer: 1-365)

### Helper Functions

#### `MoneyTransferLimitHelper::checkTransferLimit($userId)`
Returns an array with:
- `allowed` (boolean): Whether transfer is allowed
- `message` (string): Error message if not allowed
- `remaining_transfers` (integer): Number of transfers remaining
- `reset_date` (Carbon): When the limit resets

#### `MoneyTransferLimitHelper::getLimitInfo($userId)`
Returns detailed information about current limits:
- `enabled` (boolean): Whether limits are enabled
- `limit_count` (integer): Maximum transfers allowed
- `period_description` (string): Human-readable period description
- `remaining_transfers` (integer): Transfers remaining
- `reset_date` (Carbon): When limits reset
- `message` (string): User-friendly limit description

### Helper Functions (Global)

- `checkMoneyTransferLimit($userId)`: Shorthand for checking limits
- `getMoneyTransferLimitInfo($userId)`: Shorthand for getting limit info

## API Support

The money transfer limits are also enforced in the API endpoints:
- `/api/money-transfer` endpoint includes limit checks
- Same error messages and validation logic apply

## Migration

Run the migration to add the required database columns:

```bash
php artisan migrate
```

The migration file: `2024_12_30_120000_add_money_transfer_limits_to_basic_controls.php`

## Cache Considerations

- Basic control settings are cached
- After updating limit settings, cache is automatically cleared
- No manual cache clearing required

## Security Features

- Limits are checked before any money transfer processing
- Validation occurs on both web and API endpoints
- Limits cannot be bypassed through different interfaces
- All limit checks are server-side validated

## Troubleshooting

### Limits Not Working
1. Verify the migration has been run
2. Check that limits are enabled in admin settings
3. Clear application cache: `php artisan optimize:clear`

### Users Can't Transfer
1. Check if they've reached their limit
2. Verify the limit configuration is correct
3. Check if the next reset date has passed

### Incorrect Limit Calculations
1. Ensure the server timezone is configured correctly
2. Check if there are old transfers affecting the count
3. Verify the limit type matches the intended behavior

## Testing

Run the feature tests to verify functionality:

```bash
php artisan test --filter MoneyTransferLimitTest
```

The test file covers:
- Limit enabling/disabling
- Daily, weekly, and custom period limits
- Limit reset functionality
- Error message generation
- Remaining transfer calculations 
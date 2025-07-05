# RGP Points Recalculation and Recovery

Instructions for recalculating RGP (Referral Generation Points) for all users after an unexpected reset.

## What the Script Does

1. Backs up current RGP values for all users
2. Resets all users' RGP points to zero
3. Recalculates RGP points based on eligible plans
4. Propagates RGP points up the parent hierarchy
5. Deducts RGP points for matched profits (1 point = 10 Rs)
6. Creates "reset recovery" transactions if previous values were higher
7. Updates RGP pair matching values

## How to Run

### Basic Command
```
php artisan rgp:recalculate
```

### Available Options

#### Check Only Mode
To check for existing transactions without recalculating:
```
php artisan rgp:recalculate --check-only
```
This will show you existing transactions and ask if you want to proceed.

#### Preserve Mode
To recalculate points while preserving existing transactions:
```
php artisan rgp:recalculate --preserve
```
This will keep existing transactions in the database while recalculating points.

#### Reset Date
If you know when the reset occurred, you can specify a date:
```
php artisan rgp:recalculate --reset-date=2023-06-30
```
This helps the script determine which transactions to consider.

#### Debug Mode
For detailed information during processing:
```
php artisan rgp:recalculate --debug
```

## Recovery Process

The script handles recovery from unexpected RGP point resets by:

1. Backing up current RGP values before starting
2. Recalculating points based on eligible plans
3. Comparing recalculated values with backup values
4. Creating "reset recovery" transactions if backup values were higher
5. Preserving the higher values in the user's account

This ensures that users don't lose RGP points due to system issues.

## Important Notes

- Make a database backup before running
- The script will prompt for confirmation
- Progress will be displayed in the console
- Errors will be logged to Laravel log file

## After Running

After the script completes:
1. Check the logs for any errors
2. Review the created "reset recovery" transactions
3. Verify that users' RGP points have been properly restored 
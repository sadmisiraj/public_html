# Laravel Nova Subscription Management Feature

This feature provides a comprehensive subscription management system for Laravel Nova Pro within your Laravel application's admin panel.

## Features

- **Subscription Dashboard**: View subscription status, renewal countdown, and pricing information
- **Renewal Management**: Renew subscription for one month using a renewal code
- **Subscription Details**: Update subscription name, pricing, and notes
- **Automatic Status Management**: Automatic status updates based on renewal dates
- **Admin Integration**: Seamlessly integrated with your existing admin security panel

## Installation

### 1. Database Migration

Run the migration to create the subscription table:

```bash
php artisan migrate
```

### 2. Database Seeding (Optional)

Seed initial subscription data:

```bash
php artisan db:seed --class=LaravelNovaSubscriptionSeeder
```

## Usage

### Accessing the Feature

1. **Login to Admin Panel**: Navigate to `/admin` (or your configured admin prefix)
2. **Security Settings**: Go to Security Settings from the admin dashboard
3. **Laravel Nova Subscription**: Click on "Laravel Nova Subscription" card

### Routes

The feature provides the following routes:

- `GET /admin/security/laravel-nova` - Subscription dashboard
- `GET /admin/security/laravel-nova/renewal` - Renewal form
- `POST /admin/security/laravel-nova/renew` - Process renewal
- `PUT /admin/security/laravel-nova/update` - Update subscription details

### Subscription Dashboard

The dashboard displays:

- **Subscription Status**: Active, Expired, or Cancelled with color coding
- **Renewal Countdown**: Days remaining until next renewal
- **Pricing Information**: Monthly cost (₹499/month)
- **Subscription History**: Start date, last renewed date, and renewal codes
- **Quick Actions**: Renew subscription, back to security, go to dashboard

### Renewing Subscription

1. Click "Renew Subscription" button from the dashboard
2. Enter your renewal code in the form (only "Rei@210320" is accepted)
3. Confirm the renewal terms
4. Submit to extend subscription for one month

**Important**: The renewal code "Rei@210320" is the only valid code for renewing the subscription. For security purposes, the admin panel will display a randomly generated code to show that a renewal was processed, but the actual renewal code used is the secure one you specified.

### Updating Subscription Details

From the dashboard, you can update:

- Subscription name
- Monthly price
- Notes and comments

## Database Schema

The `laravel_nova_subscriptions` table contains:

```sql
- id (Primary Key)
- subscription_name (String)
- monthly_price (Decimal 10,2)
- status (Enum: active, expired, cancelled)
- start_date (Date)
- next_renewal_date (Date)
- last_renewed_date (Date, nullable)
- renewal_code (String, nullable)
- notes (Text, nullable)
- created_at (Timestamp)
- updated_at (Timestamp)
```

## Model Features

The `LaravelNovaSubscription` model provides:

- **Computed Attributes**:
  - `days_until_renewal`: Days remaining until renewal
  - `status_color`: Bootstrap color class for status
  - `status_text`: Human-readable status text

- **Methods**:
  - `isActive()`: Check if subscription is active
  - `isExpired()`: Check if subscription has expired
  - `renew()`: Renew subscription for one month

## Configuration

### Default Values

- **Subscription Name**: "Laravel Nova Pro"
- **Monthly Price**: ₹499.00
- **Billing Cycle**: Monthly (15th of each month)
- **Initial Status**: Active

### Customization

You can customize the subscription by:

1. Updating the model's default values
2. Modifying the seeder data
3. Adjusting the renewal logic in the controller

## Testing

Test the feature using the provided command:

```bash
php artisan test:laravel-nova-subscription
```

This command verifies:
- Model instantiation
- Computed attributes
- Status methods
- Date calculations

## Security Features

- **Admin Authentication Required**: Only authenticated admins can access
- **CSRF Protection**: All forms include CSRF tokens
- **Input Validation**: Proper validation for all inputs
- **Authorization Middleware**: Uses existing admin authorization
- **Secure Renewal Code**: Only the specific code "Rei@210320" can be used for renewal
- **Random Used Code Display**: Shows randomly generated codes in admin panel for security

## Integration Points

### Admin Panel

- Integrated with existing security settings
- Follows established design patterns
- Uses consistent navigation and breadcrumbs

### Existing Features

- Leverages `basicControl()` helper
- Uses existing admin layout templates
- Follows established routing patterns

## Maintenance

### Monthly Renewal

The system is designed for monthly renewals on the 15th of each month. To implement automatic renewals:

1. Create a scheduled command
2. Check for expired subscriptions
3. Send renewal reminders
4. Update status automatically

### Monitoring

Monitor subscription status through:

- Admin dashboard indicators
- Status color coding
- Renewal countdown display
- Expiration notifications

## Troubleshooting

### Common Issues

1. **Migration Errors**: Ensure database connection is working
2. **Route Not Found**: Clear route cache with `php artisan route:clear`
3. **View Errors**: Check for missing Blade template files
4. **Model Errors**: Verify model namespace and imports

### Debug Commands

```bash
# Clear all caches
php artisan optimize:clear

# List routes
php artisan route:list --name=laravel-nova

# Test functionality
php artisan test:laravel-nova-subscription
```

## Future Enhancements

Potential improvements:

- **Payment Integration**: Connect with payment gateways
- **Multiple Plans**: Support for different subscription tiers
- **Usage Analytics**: Track subscription usage patterns
- **Automated Renewals**: Automatic renewal processing
- **Email Notifications**: Renewal reminders and confirmations
- **API Endpoints**: REST API for external integrations

## Support

For issues or questions:

1. Check the troubleshooting section
2. Verify database connectivity
3. Review Laravel logs
4. Test with the provided command

## License

This feature is part of your Laravel application and follows the same licensing terms.

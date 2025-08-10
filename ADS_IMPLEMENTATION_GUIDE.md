# Google Ads Implementation Guide

## Overview
This implementation ensures that Google Ads are shown only to users who log in through the normal login page (`/login`) and **NOT** to users who log in through the admin panel (`/security`) or users who are logged in by admin users.

**Additional Exclusions:**
- Users with specific IDs: 51, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 95, 201, 360, 362, 421, 422, 446
- Users whose `zip_code` field is null or empty

## How It Works

### 1. Session Flags
When users log in, the system sets session flags to track the login source:

- **Normal Login** (`/login`): Sets `show_ads = true` and `login_source = 'normal_login'`
- **Admin Login as User** (`/security/login/as/user/{id}`): Sets `show_ads = false` and `login_source = 'admin_login'`

### 2. Helper Functions
Two helper functions are available globally:

- `shouldShowAds()`: Returns `true` only for users who should see ads (checks login source, user ID exclusions, and zip_code)
- `getLoginSource()`: Returns the source of the user's login for debugging

### 3. Ad Exclusion Rules
Ads will NOT be shown if any of the following conditions are met:

1. User is not authenticated
2. User logged in through admin panel or was logged in by an admin
3. User ID is in the excluded list: [51, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 95, 201, 360, 362, 421, 422, 446]
4. User's `zip_code` field is null or empty

### 4. Automatic Ad Loading
The Google AdSense script in `resources/views/plugins.blade.php` now loads only when `shouldShowAds()` returns `true`.

## Testing Instructions

### Step 1: Test Normal User Login (Should Show Ads)
1. Go to `http://127.0.0.1:8000/login`
2. Login with a regular user account (not in excluded list and has zip_code)
3. After login, visit `http://127.0.0.1:8000/debug-ads`
4. You should see:
   ```json
   {
     "should_show_ads": true,
     "login_source": "normal_login",
     "session_show_ads": true,
     "session_login_source": "normal_login",
     "exclusion_reasons": {
       "not_authenticated": false,
       "excluded_user_id": false,
       "null_zip_code": false,
       "wrong_login_source": false
     }
   }
   ```

### Step 2: Test Admin Login as User (Should NOT Show Ads)
1. Go to `http://127.0.0.1:8000/security`
2. Login as admin
3. Go to user management and click "Login As User" for any user
4. After being logged in as that user, visit `http://127.0.0.1:8000/debug-ads`
5. You should see:
   ```json
   {
     "should_show_ads": false,
     "login_source": "admin_login",
     "session_show_ads": false,
     "session_login_source": "admin_login",
     "exclusion_reasons": {
       "wrong_login_source": true
     }
   }
   ```

### Step 3: Test Excluded User ID (Should NOT Show Ads)
1. Login normally with a user whose ID is in the excluded list (51, 67, 68, etc.)
2. Visit `http://127.0.0.1:8000/debug-ads`
3. You should see:
   ```json
   {
     "should_show_ads": false,
     "is_user_excluded": true,
     "exclusion_reasons": {
       "excluded_user_id": true
     }
   }
   ```

### Step 4: Test Null Zip Code (Should NOT Show Ads)
1. Login normally with a user whose `zip_code` field is null or empty
2. Visit `http://127.0.0.1:8000/debug-ads`
3. You should see:
   ```json
   {
     "should_show_ads": false,
     "zip_code": null,
     "has_zip_code": false,
     "exclusion_reasons": {
       "null_zip_code": true
     }
   }
   ```

## Files Modified

### 1. `app/Http/Controllers/Auth/LoginController.php`
- Modified `authenticated()` method to set ads flag for normal logins
- Modified `loginModal()` method to set ads flag for modal logins

### 2. `app/Http/Controllers/Admin/UsersController.php`
- Modified `loginAsUser()` method to prevent ads for admin-initiated logins

### 3. `app/Helpers/helpers.php`
- Added `shouldShowAds()` helper function
- Added `getLoginSource()` helper function for debugging

### 4. `resources/views/plugins.blade.php`
- Separated Google AdSense script from Analytics
- Added condition to load AdSense only when `shouldShowAds()` is true

### 5. `routes/web.php`
- Added debug route at `/debug-ads` for testing

## Usage in Blade Templates

To conditionally show ads in any Blade template:

```php
@if(shouldShowAds())
    <!-- Your ad code here -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-8596056517622475"
         data-ad-slot="YOUR_AD_SLOT_ID"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
@endif
```

## Important Notes

1. **Session-based**: The implementation uses session flags, so the behavior persists throughout the user's session.

2. **Automatic**: The main AdSense script in `plugins.blade.php` is automatically controlled, so existing ads will already be affected.

3. **Flexible**: You can use `shouldShowAds()` in any Blade template for additional ad placements.

4. **Debug-friendly**: Use `/debug-ads` route to verify the current user's ad status.

5. **Clean up**: Remember to remove the debug route and debug info from templates in production.

## Verification Checklist

- [ ] Normal login shows ads (`should_show_ads: true`)
- [ ] Admin login as user doesn't show ads (`should_show_ads: false`)  
- [ ] Users in excluded ID list don't see ads (IDs: 51, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 95, 201, 360, 362, 421, 422, 446)
- [ ] Users with null/empty zip_code don't see ads
- [ ] AdSense script loads only when it should
- [ ] Session persists throughout user session
- [ ] No ads appear for admin-initiated user sessions
- [ ] Debug route shows correct exclusion reasons

The implementation is now complete and ready for testing! 
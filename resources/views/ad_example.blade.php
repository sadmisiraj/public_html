{{-- Example of how to conditionally show ads in any Blade template --}}

@if(shouldShowAds() && 1==0)
    {{-- Display ads only for users who logged in through normal login page --}}
    <div class="advertisement-section">
        <h4>Advertisement</h4>
        {{-- Your Google Ad code here --}}
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-8596056517622475"
             data-ad-slot="YOUR_AD_SLOT_ID"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
    </div>
@endif

{{-- Debug information (remove this in production) --}}
@if(config('app.debug'))
    @php
        $user = Auth::user();
        $excludedUserIds = [51, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 95, 201, 360, 362, 421, 422, 446];
    @endphp
    <div class="debug-info" style="background: #f8f9fa; padding: 10px; margin: 10px 0; border-left: 4px solid #007bff;">
        <small>
            <strong>Ads Debug Info:</strong><br>
            Should Show Ads: {{ shouldShowAds() ? 'Yes' : 'No' }}<br>
            Login Source: {{ getLoginSource() }}<br>
            User: {{ Auth::check() ? Auth::user()->username : 'Not logged in' }}<br>
            User ID: {{ $user ? $user->id : 'N/A' }}<br>
            Is Excluded User: {{ $user && in_array($user->id, $excludedUserIds) ? 'Yes' : 'No' }}<br>
            Zip Code: {{ $user ? ($user->zip_code ?: 'NULL/Empty') : 'N/A' }}<br>
            <strong>Exclusion Reasons:</strong><br>
            - Not Authenticated: {{ !Auth::check() ? 'Yes' : 'No' }}<br>
            - Excluded User ID: {{ $user && in_array($user->id, $excludedUserIds) ? 'Yes' : 'No' }}<br>
            - Null/Empty Zip Code: {{ $user && (is_null($user->zip_code) || empty($user->zip_code)) ? 'Yes' : 'No' }}<br>
            - Wrong Login Source: {{ !session('show_ads', false) ? 'Yes' : 'No' }}
        </small>
    </div>
@endif 
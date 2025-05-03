<?php
/**
 * This script updates all registration templates to:
 * 1. Remove the username field (as it will be auto-generated)
 * 2. Add validation for sponsor field with proper handling of URL parameters
 */

$basePath = __DIR__ . '/resources/views/themes';
$dirs = scandir($basePath);

foreach ($dirs as $dir) {
    if ($dir === '.' || $dir === '..' || !is_dir($basePath . '/' . $dir)) {
        continue;
    }

    $registerFile = $basePath . '/' . $dir . '/auth/register.blade.php';
    if (!file_exists($registerFile)) {
        echo "Register file not found for theme: $dir\n";
        continue;
    }

    $content = file_get_contents($registerFile);

    // Skip already updated files that have the latest changes
    if (strpos($content, 'validSponsor') !== false) {
        echo "Theme $dir already has the latest updates\n";
        continue;
    }

    // Replace the username field
    $content = preg_replace(
        '/<div[^>]*>\s*<(?:input|div)[^>]*name="username"[^>]*>.*?<\/div>\s*<\/div>/s',
        '',
        $content
    );

    // Get the sponsor field content
    preg_match('/@if\(session\(\)->get\(\'sponsor\'\)[^\)]*\)(.*?)@endif/s', $content, $sponsorMatch);
    
    $newSponsorField = <<<HTML
<div class="col-md-12 form-floating">
    <div class="input-group">
        <input type="text" name="sponsor" class="form-control" id="sponsor"
               placeholder="{{trans('Sponsor By') }}"
               value="{{ \$sponsor ?? '' }}" {{ isset(\$validSponsor) && \$validSponsor ? 'readonly' : '' }} autocomplete="off"/>
        @if(!isset(\$validSponsor) || !\$validSponsor)
            <button type="button" class="btn btn-info validate-sponsor" id="validate-sponsor">@lang('Validate')</button>
        @endif
    </div>
    <div id="sponsor-name" class="mt-2">
        @if(isset(\$validSponsor) && \$validSponsor && isset(\$sponsorUser))
            <span class="text-success">Referrer: {{ \$sponsorUser->fullname }}</span>
        @endif
    </div>
    @error('sponsor')<span class="text-danger mt-1">@lang(\$message)</span>@enderror
</div>
HTML;

    // Replace the sponsor field
    if (!empty($sponsorMatch[0])) {
        $content = str_replace($sponsorMatch[0], $newSponsorField, $content);
    } else {
        // If no sponsor field, add it after the form title
        $content = preg_replace(
            '/<h[^>]*>.*?<\/h[^>]*>\s*(<\/div>)?/s', 
            '$0' . $newSponsorField,
            $content,
            1
        );
    }

    // Add the disabled attribute to the register button
    $content = preg_replace(
        '/(<button[^>]*type="submit"[^>]*)>/i',
        '$1 id="register-btn" {{ isset(\$validSponsor) && \$validSponsor ? \'\' : \'disabled\' }}>',
        $content
    );

    // Add the JavaScript for sponsor validation
    $validationScript = <<<JS
<script>
    $(document).ready(function(){
        // Enable/disable register button based on sponsor validation
        function updateRegisterButton() {
            if ($('#sponsor-name').hasClass('text-success') || $('#sponsor-name').find('.text-success').length > 0) {
                $('#register-btn').prop('disabled', false);
            } else {
                $('#register-btn').prop('disabled', true);
            }
        }
        
        // If sponsor is already set from URL and is valid, enable registration
        if ($('#sponsor').val() && $('#sponsor').prop('readonly') && $('#sponsor-name').find('.text-success').length > 0) {
            updateRegisterButton();
        }
        
        // Validate sponsor on button click
        $('#validate-sponsor').on('click', function() {
            validateSponsor();
        });
        
        // Also validate on input change
        $('#sponsor').on('change', function() {
            if ($(this).val()) {
                validateSponsor();
            } else {
                $('#sponsor-name').html('<span class="text-danger">Referral code is required</span>');
                updateRegisterButton();
            }
        });
        
        function validateSponsor() {
            let sponsor = $('#sponsor').val();
            if (!sponsor) {
                $('#sponsor-name').html('<span class="text-danger">Referral code is required</span>');
                updateRegisterButton();
                return;
            }
            
            $.ajax({
                url: '{{ route("check.referral.code") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    sponsor: sponsor
                },
                success: function(response) {
                    if (response.success) {
                        $('#sponsor-name').html('<span class="text-success">Referrer: ' + response.data.name + '</span>');
                    } else {
                        $('#sponsor-name').html('<span class="text-danger">Invalid referral code</span>');
                    }
                    updateRegisterButton();
                },
                error: function() {
                    $('#sponsor-name').html('<span class="text-danger">Error validating referral code</span>');
                    updateRegisterButton();
                }
            });
        }
    });
</script>
JS;

    // Add the validation script to the end of the file
    if (strpos($content, '@push(\'script\')') !== false) {
        // Clean up any existing implementation first
        $content = preg_replace(
            '/function updateRegisterButton\(\)[^}]+}\s*if \(\$\(\'#sponsor\'\)\.val\(\)[^}]+}\s*\$\(\'#validate-sponsor\'\)\.on\(\'click\'[^}]+}\s*\$\(\'#sponsor\'\)\.on\(\'change\'[^}]+}\s*function validateSponsor\(\)[^}]+}[^}]+}[^}]+}[^}]+}/s',
            '',
            $content
        );
        // Add inside existing script push
        $content = preg_replace(
            '/@push\(\'script\'\)\s*(.*?)@endpush/s',
            "@push('script')\$1" . $validationScript . "\n@endpush",
            $content
        );
    } else {
        // Add as new script push at the end
        $content = preg_replace(
            '/@endsection\s*$/s',
            "@endsection\n\n@push('script')\n" . $validationScript . "\n@endpush",
            $content
        );
    }

    // Write the updated content back to the file
    file_put_contents($registerFile, $content);
    echo "Updated registration template for theme: $dir\n";
}

echo "Update completed!\n"; 
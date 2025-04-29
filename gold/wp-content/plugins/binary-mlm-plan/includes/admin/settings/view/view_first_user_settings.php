<?php
global $wpdb;
$users = $wpdb->get_results($wpdb->prepare("SELECT u.* FROM {$wpdb->prefix}users as u JOIN {$wpdb->prefix}usermeta as um On u.id=um.user_id AND um.meta_key=%s AND um.meta_value NOT LIKE %s", 'wp_capabilities', '%administrator%'));  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.NoCaching 
?>
<div class="card w-100 p-0 mw-100">
    <div class="card-header">
        <?php esc_html_e('Binary MLM Fisrt User Create', 'binary-mlm-plan'); ?>
    </div>
    <div class="card-body">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="" data-toggle="tooltip" class="label-control" title="" data-original-title="!"><?php esc_html_e('Binary MLM User By Existing User', 'binary-mlm-plan'); ?> </label>
                <select name="bmp_existing_user" id="bmp_existing_user" class="form-control" required>
                    <option value=""><?php esc_html_e('Select User', 'binary-mlm-plan'); ?></option>
                    <?php foreach ($users as $user) { ?>
                        <option value="<?php echo esc_attr($user->ID); ?>"><?php echo esc_attr($user->user_login); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <input type="checkbox" name="new_bmp_user" id="new_bmp_user" value="1">
                <span class="ml-5">
                    <?php esc_html_e(' New Binary MLM User Create', 'binary-mlm-plan'); ?>
                </span>
            </div>
        </div>
        <div id="bmp_new_user" class="col-md-12">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('User Name', 'binary-mlm-plan'); ?> </label>
                        <input type="text" class="form-control" name="bmp_first_username" id="bmp_first_username">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('User Email', 'binary-mlm-plan'); ?> </label>
                        <input type="email" class="form-control" name="bmp_first_email" id="bmp_first_email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('Password', 'binary-mlm-plan'); ?> </label>
                        <input type="password" class="form-control" name="bmp_first_password" id="bmp_first_password">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="" data-toggle="tooltip" title="" data-original-title="!"><?php esc_html_e('Confirm Password', 'binary-mlm-plan'); ?> </label>
                        <input type="password" class="form-control" name="bmp_first_confirm_password" id="bmp_first_confirm_password">
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                if ($('#new_bmp_user').is(':checked')) {
                    $('#bmp_new_user').css('display', 'block');
                    $('#bmp_existing_user').removeAttr('required');
                    $('#bmp_first_username').attr('required', true);
                    $('#bmp_first_email').attr('required', true);
                    $('#bmp_first_password').attr('required', true);
                    $('#bmp_first_confirm_password').attr('required', true);
                }

                $('#new_bmp_user').click(function() {
                    if ($(this).is(':checked')) {
                        $('#bmp_new_user').css('display', 'block');
                        $('#bmp_existing_user').removeAttr('required');
                        $('#bmp_first_username').attr('required', true);
                        $('#bmp_first_email').attr('required', true);
                        $('#bmp_first_password').attr('required', true);
                        $('#bmp_first_confirm_password').attr('required', true);
                    } else {
                        $('#bmp_new_user').css('display', 'none');
                        $('#bmp_existing_user').attr('required', true);
                        $('#bmp_first_username').removeAttr('required');
                        $('#bmp_first_email').removeAttr('required');
                        $('#bmp_first_password').removeAttr('required');
                        $('#bmp_first_confirm_password').removeAttr('required');
                    }
                });
            });
        </script>
    </div>
</div>
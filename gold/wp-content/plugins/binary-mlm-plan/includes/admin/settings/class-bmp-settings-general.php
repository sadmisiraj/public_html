<?php

/**
 * UMW General Settings
 *
 * @package UMW/Admin
 */


if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('BMP_Settings_General', false)) {
    return new BMP_Settings_General();
}

/**
 * BMP_Admin_Settings_General.
 */
class BMP_Settings_General extends BMP_Settings_Page
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id    = 'setting';
        $this->label = __('Setting', 'binary-mlm-plan');

        parent::__construct();

        add_action('bmp_settings_save_' . $this->id, array($this, 'save'));
        add_action('bmp_sections_' . $this->id, array($this, 'output_sections'));
        add_action('bmp_settings_' . $this->id, array($this, 'output'));
    }


    public function get_sections()
    {
        global $wpdb;

        $general_settings = get_option('bmp_manage_general');
        $sections = array();

        $user_count = $this->bmpUserCount();

        if ($user_count < 1) {
            $sections['first_user'] = __('First User', 'binary-mlm-plan');
        }

        $sections['general'] = esc_html__('General', 'binary-mlm-plan');
        $sections['eligibility'] = esc_html__('Eligibility', 'binary-mlm-plan');
        $sections['payout'] = esc_html__('Payout', 'binary-mlm-plan');
        $sections['generate-epin'] = esc_html__('Generate Epin', 'binary-mlm-plan');
        $sections['pro-features'] = esc_html__('Pro Features', 'binary-mlm-plan');
        return apply_filters('bmp_get_sections_' . $this->id, $sections);
    }

    public function output_sections()
    {
        global $current_section;

        $sections = $this->get_sections();

        if (empty($sections) || 1 === sizeof($sections)) {
            return;
        }

        $array_keys = array_keys($sections);

        echo '<div class="wrap_style"><ul>';
        foreach ($sections as $id => $label) {
            echo '<li class="list_style ' . ($current_section == $id ? 'current' : '') . '"><a href="' . esc_html(admin_url('admin.php?page=bmp-settings&tab=' . $this->id . '&section=' . sanitize_title($id))) . '">' . esc_attr($label) . '</a></li>';
        }
        echo '</ul></div>';
    }



    /**
     * Get settings array.
     *
     * @return array
     */
    public function get_settings($current_section = '')
    {
        $settings = array();
        if ('' === $current_section) {
            $array_setings = include 'view/view_general_settings.php';
            $settings = apply_filters('bmp_general_settings', $array_setings);
        } elseif ('eligibility' === $current_section) {
            $array_setings = include 'view/view_eligibility_settings.php';
            $settings = apply_filters('bmp_eligibility_settings', $array_setings);
        } elseif ('payout' === $current_section) {
            $array_setings = include 'view/view_payout_settings.php';
            $settings = apply_filters('bmp_payout_settings', $array_setings);
        } elseif ('generate-epin' === $current_section) {
            $array_setings = include 'view/view_epin_settings.php';
            $settings = apply_filters('bmp_epin_settings', $array_setings);
        } elseif ('pro-features' === $current_section) {
            $array_setings = include 'view/pro-features.php';
        }


        return apply_filters('bmp_get_settings_' . $this->id, $settings);
    }


    public function getepinlength()
    {
        return array('5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10', '11' => '11', '12');
    }

    public function output()
    {
        global $current_section; ?>

        <div class="content_style">
            <div class="container-fluid p-0">
                <?php
                if ($current_section == 'payout') {
                    $this->bmpUserRedirect();
                    include 'view/view_payout_settings.php';
                } elseif ($current_section == 'eligibility') {
                    $this->bmpUserRedirect();
                    include 'view/view_eligibility_settings.php';
                } elseif ($current_section == 'generate-epin') {
                    $this->bmpUserRedirect();
                    include 'view/view_epin_settings.php';
                } elseif ($current_section == 'pro-features') {
                    include 'view/pro-features.php';
                } elseif ($current_section == 'general') {
                    $this->bmpUserRedirect();
                    include 'view/view_general_settings.php';
                } elseif ($current_section == 'first_user') {
                    $bmp_user_count = $this->bmpUserCount();
                    if ($bmp_user_count > 0) {
                        wp_redirect(admin_url('admin.php?page=bmp-settings&tab=' . $this->id . '&section=general'));
                        exit;
                    }
                    include 'view/view_first_user_settings.php';
                } else {
                    $this->bmpUserRedirect();
                    include 'view/view_general_settings.php';
                } ?>
            </div>
        </div>
<?php

    }

    public function bmpUserRedirect()
    {
        $bmp_user_count = $this->bmpUserCount();
        if ($bmp_user_count == 0) {
            wp_redirect(admin_url('admin.php?page=bmp-settings&tab=' . $this->id . '&section=first_user'));
            exit;
        }
    }

    /**
     * Save settings.
     */

    public function save()
    {
        global $current_section;

        if (isset($_POST['bmp_nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
            wp_die('Security check');
        } else {
            if (!$current_section) {
                $this->manageGeneral($_POST);
            }

            if ($current_section) {
                if ($current_section == 'payout') {
                    $this->managePayout($_POST);
                } elseif ($current_section == 'eligibility') {
                    $this->manageEligibility($_POST);
                } elseif ($current_section == 'general') {
                    $this->manageGeneral($_POST);
                } elseif ($current_section == 'generate-epin') {
                    $this->manageEpin($_POST);
                } elseif ($current_section == 'first_user') {

                    $this->manageFirstUser($_POST);
                } else {
                    $this->manageGeneral($_POST);
                }
            }
        }
    }

    public function manageFirstUser($data)
    {
        global $wpdb;
        global $wp_session;
        $flag = true;
        if ($data['new_bmp_user']) {
            if (username_exists($data['bmp_first_username'])) {
                $wp_session['bmp_save_error'] = __('User Name Already Exist. Please try another user name.', 'binary-mlm-plan');
                BMP_Admin_Settings::add_error(__('User Name Already Exist. Please try another user name.', 'binary-mlm-plan'));
                $flag = false;
            }

            if (email_exists($data['bmp_first_email'])) {
                $wp_session['bmp_save_error'] = __('User Email Alraedy Exists.Please use another email', 'binary-mlm-plan');
                BMP_Admin_Settings::add_error(__('User Email Alraedy Exists.Please use another email', 'binary-mlm-plan'));
                $flag = false;
            }

            if ($data['bmp_first_password'] != $data['bmp_first_confirm_password']) {
                $wp_session['bmp_save_error'] = __('Password Does not match', 'binary-mlm-plan');
                BMP_Admin_Settings::add_error(__('Password Does not match', 'binary-mlm-plan'));
                $flag = false;
            }

            if ($flag) {
                $userdata = array(
                    'user_login' =>  $data['bmp_first_username'],
                    'user_email' => $data['bmp_first_email'],
                    'user_pass'  =>  $data['bmp_first_password']
                );

                $user_id = wp_insert_user($userdata);

                // On success.
                if (!is_wp_error($user_id)) {
                    $bmp_user = new WP_User($user_id);
                    $bmp_user->set_role('bmp_user');
                    $user_key = bmp_generateKey();

                    $wpdb->query($wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                        "INSERT INTO {$wpdb->prefix}bmp_users (user_id, user_name, user_key, parent_key, sponsor_key, position, payment_status)
                          VALUES(%d, %s, %s, %s, %s, %s, %s)",
                        $user_id,
                        $data['bmp_first_username'],
                        $user_key,
                        '0',
                        '0',
                        'left',
                        '1'
                    ));
                    $wp_session['bmp_save_message'] = __('Binary MLM Plan User created successfully.', 'binary-mlm-plan');
                    BMP_Admin_Settings::add_message(__('Binary MLM Plan User created successfully.', 'binary-mlm-plan'));
                }
            }
        } else {
            $user_id = $data['bmp_existing_user'];
            $bmp_user = new WP_User($user_id);
            $bmp_user->set_role('bmp_user');
            $user_key = bmp_generateKey();

            $wpdb->query($wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                "INSERT INTO {$wpdb->prefix}bmp_users (user_id, user_name, user_key, parent_key, sponsor_key, position, payment_status)
                          VALUES(%d, %s, %s, %d, %d, %s, %d)",
                $user_id,
                $bmp_user->user_login,
                $user_key,
                0,
                0,
                'left',
                1
            ));
            $wp_session['bmp_save_message'] = __('Binary MLM Plan User created successfully.', 'binary-mlm-plan');
            BMP_Admin_Settings::add_message(__('Binary MLM Plan User created successfully.', 'binary-mlm-plan'));
        }

        wp_safe_redirect(admin_url('admin.php?page=bmp-settings&tab=setting&section=general'));
    }

    public function bmpUserCount()
    {
        global $wpdb;
        return $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$wpdb->prefix}bmp_users where 1=%d", 1)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }



    public function manageGeneral($data)
    {
        global $wp_session;

        update_option('bmp_manage_general', $data);
        $wp_session['bmp_save_message'] = __('General Settings Has been save successfully.', 'binary-mlm-plan');
        // BMP_Admin_Settings::add_message(__('General Settings Has been save successfully.', 'binary-mlm-plan'));

        wp_safe_redirect(admin_url('admin.php?page=bmp-settings&tab=setting&section=eligibility'));
    }

    public function manageEligibility($data)
    {
        global $wp_session;
        if (isset($data['bmp_referral']) && is_numeric($data['bmp_referral']) && isset($data['bmp_referral_left']) && is_numeric($data['bmp_referral_left']) && isset($data['bmp_referral_right']) && is_numeric($data['bmp_referral_right'])) {
            update_option('bmp_manage_eligibility', $data);
            $wp_session['bmp_save_message'] = __('Eligibility Settings Has been save successfully.', 'binary-mlm-plan');
            BMP_Admin_Settings::add_message(__('Eligibility Settings Has been save successfully.', 'binary-mlm-plan'));
            wp_safe_redirect(admin_url('admin.php?page=bmp-settings&tab=setting&section=payout'));
        }
    }
    public function manageEpin($data)
    {
        global $wpdb;
        $epin_type = '';
        $epin_numbrer = 0;
        $epin_length = 0;
        $epin_name = '';
        $epins = [];
        $epin_price = 0;
        if (isset($data['bmp_epin_name']) && !empty($data['bmp_epin_name'])) {
            $epin_name = $data['bmp_epin_name'];
        }
        if (isset($data['bmp_epin_type']) && !empty($data['bmp_epin_type'])) {
            $epin_type = $data['bmp_epin_type'];
        }
        if (isset($data['bmp_epin_number']) && !empty($data['bmp_epin_number'])) {
            $epin_numbrer = $data['bmp_epin_number'];
        }
        if (isset($data['bmp_epin_length']) && !empty($data['bmp_epin_length'])) {
            $epin_length = $data['bmp_epin_length'];
        }
        if (isset($data['bmp_epin_price']) && !empty($data['bmp_epin_price'])) {
            $epin_price = $data['bmp_epin_price'];
        }
        if (!empty($epin_name) && !empty($epin_type) && !empty($epin_numbrer) && !empty($epin_length) &&  !empty($epin_price)) {
            $epins = bmp_epinGenarate($epin_length, $epin_numbrer, $epin_name);
            if (!empty($epins)) {
                foreach ($epins as $epin) {
                    $wpdb->query($wpdb->prepare( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                        "INSERT INTO {$wpdb->prefix}bmp_epins (epin_name, epin_no, type, date_generated, user_key, date_used, status, epin_price) 
                        VALUES (%s, %s, %s, %s, %d, %s, %s, %f)",
                        $epin_name,
                        $epin,
                        $epin_type,
                        gmdate('Y-m-d'),
                        0,
                        '0000-00-00',
                        '0',
                        $epin_price
                    ));
                }
            }
        }
    }

    public function managePayout($data)
    {
        global $wp_session;
        if (isset($data['bmp_referral_commission_amount']) && is_numeric($data['bmp_referral_commission_amount']) && isset($data['bmp_service_charge_amount']) && is_numeric($data['bmp_service_charge_amount']) && isset($data['bmp_tds']) && is_numeric($data['bmp_tds']) && isset($data['bmp_cap_limit_amount']) && is_numeric($data['bmp_cap_limit_amount'])) {
            update_option('bmp_manage_payout', $data);
            $wp_session['bmp_save_message'] = __('Payout Settings Has been save successfully.', 'binary-mlm-plan');
            BMP_Admin_Settings::add_message(__('Payout Settings Has been save successfully.', 'binary-mlm-plan'));
            wp_safe_redirect(admin_url('admin.php?page=bmp-settings&tab=setting&section=bonus'));
        }
    }
}

//return new BMP_Settings_General();

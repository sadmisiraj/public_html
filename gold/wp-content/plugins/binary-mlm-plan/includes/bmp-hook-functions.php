<?php
if (!defined('ABSPATH')) {
    exit;
}

function bmp_epinGenarate($pin_length = '', $no_of_epin = '', $epin_name = '')
{
    global $wpdb;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $epins = [];
    for ($i = 0; $i < $no_of_epin; $i++) {
        do {
            $randomString = '';
            for ($j = 0; $j < $pin_length; $j++) {
                $index = wp_rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            $has_epin = $wpdb->get_var($wpdb->prepare("SELECT count(*) from {$wpdb->prefix}bmp_epins WHERE epin_name=%s AND epin_no=%s", $epin_name, $randomString)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        } while ($has_epin > 0);

        if (!array_search($randomString, $epins)) {
            $epins[] = $randomString;
        }
    }

    return $epins;
}

function bmp_run_payout_functions()
{
    global $wpdb;
    $results = bmp_run_payout_display_functions();

    if ($wpdb->num_rows > 0) {
        if ($results) {
            foreach ($results as $row) {
                /***********************************************************
                INSERT INTO PAYOUT TABLE
                 ***********************************************************/
                $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                    $wpdb->prepare(
                        "INSERT INTO {$wpdb->prefix}bmp_payout(user_id, date, commission_amount,referral_commission_amount,bonus_amount,total_amount,capped_amount,cap_limit,tax, service_charge) VALUES (%d, %s, %f, %f, %f, %f, %f, %f, %f, %f)",
                        $row['user_id'],
                        gmdate('Y-m-d H:i:s'),
                        $row['commission_amount'],
                        $row['direct_refferal_commission'],
                        0,
                        $row['net_amount'],
                        $row['net_amount'],
                        $row['cap_limit'],
                        $row['tax'],
                        $row['service_charge']
                    )
                );

                $payout_id = $wpdb->insert_id;

                $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}bmp_referral_commission set payout_id=%d where sponsor_id=%d AND payout_id=0", $payout_id, $row['user_id'])); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

                $bmp_manage_email = get_option('bmp_manage_email');

                if (isset($bmp_manage_email['bmp_payout_mail']) && !empty($bmp_manage_email['bmp_payout_mail']) && $bmp_manage_email['bmp_payout_mail'] == 1) {
                    bmp_payout_generated_mail($row['user_id'], $row['net_amount'], $payout_id);
                }
            }
        }
    }
    //return "Payout Run Successfully";
}


function bmp_run_payout_display_functions()
{
    global $wpdb;
    $displayDataArray = [];

    $results = $wpdb->get_results( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        $wpdb->prepare(
            "SELECT user_id FROM {$wpdb->prefix}bmp_users 
    WHERE user_id IN (
        SELECT sponsor_id AS user_id FROM {$wpdb->prefix}bmp_referral_commission 
        WHERE payout_id = %d 
        UNION 
        SELECT sponsor_id AS user_id FROM {$wpdb->prefix}bmp_referral_commission 
        WHERE payout_id = %d
    )",
            0,
            0
        )
    );

    if ($wpdb->num_rows > 0) {
        $i = 0;
        foreach ($results as $key => $row) {
            $userId = $row->user_id;
            $directReffComm = bmp_getReferralCommissionById($row->user_id);

            $totalamount = $directReffComm;

            $bmp_manage_payout = get_option('bmp_manage_payout');
            $tax = $bmp_manage_payout['bmp_tds'];
            $service_charge = $bmp_manage_payout['bmp_service_charge_amount'];
            $capLimitAmt = !empty($bmp_manage_payout['bmp_cap_limit_amount']) ? $bmp_manage_payout['bmp_cap_limit_amount'] : '';

            if ($totalamount <= $capLimitAmt) {
                $total = $totalamount;
            } else {
                $total = empty($capLimitAmt) ? $totalamount : ($capLimitAmt == '0.00' ? $totalamount : $capLimitAmt);
            }
            if (!empty($totalamount) && $totalamount > 0) {
                $commission_amount = $totalamount;
                $taxamount = round(($total) * $tax / 100, 2);
                if ($bmp_manage_payout['bmp_service_charge_type'] == 'fixed')
                    $service_charge = $service_charge;
                if ($bmp_manage_payout['bmp_service_charge_type'] == 'percentage')
                    $service_charge = round(($total) * $service_charge / 100, 2);
                $user_info = get_userdata($row->user_id);
                $displayDataArray[$key]['user_id'] = $userId;
                $displayDataArray[$key]['username'] = $user_info->user_login;
                $displayDataArray[$key]['first_name'] = $user_info->first_name == "" ? $user_info->user_login : $user_info->first_name;
                $displayDataArray[$key]['last_name'] = $user_info->last_name == "" ? $user_info->user_login : $user_info->last_name;
                $displayDataArray[$key]['direct_refferal_commission'] = $directReffComm;
                $displayDataArray[$key]['total_amount'] = $totalamount;
                $displayDataArray[$key]['cap_limit'] = $capLimitAmt;
                $displayDataArray[$key]['commission_amount'] = $commission_amount;
                $displayDataArray[$key]['tax'] = $taxamount;
                $displayDataArray[$key]['service_charge'] = $service_charge == "" ? 0.00 : $service_charge;
                $displayDataArray[$key]['net_amount'] = ($total - $service_charge - $taxamount);
                $i++;
            }
        }
    } else {
        $displayDataArray = "";
    }


    return $displayDataArray;
}

function bmp_eligibility_check_for_commission($user_key)
{
    global $wpdb;
    //get the eligibility for commission and bonus
    $bmp_manage_eligibility = get_option('bmp_manage_eligibility');

    $left_referrals = 0;
    $right_referrals = 0;
    $direct_referrals = 0;
    $setting_left_ref = isset($bmp_manage_eligibility['bmp_referral_left']) ? $bmp_manage_eligibility['bmp_referral_left'] : 0;
    $setting_right_ref = isset($bmp_manage_eligibility['bmp_referral_right']) ? $bmp_manage_eligibility['bmp_referral_right'] : 0;
    $setting_direct_ref = isset($bmp_manage_eligibility['bmp_referral']) ? $bmp_manage_eligibility['bmp_referral'] : 0;
    $paid_sponsor = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}bmp_users WHERE user_key = %s AND payment_status = '1'", $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    if ($paid_sponsor == 0) {
        return false;
    } else {
        $left_referrals = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}bmp_users WHERE sponsor_key = %s AND position = 'left'", $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        $right_referrals = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}bmp_users WHERE sponsor_key = %s AND position = 'right'", $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

        $direct_referrals = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->prefix}bmp_users WHERE parent_key=%s AND sponsor_key = %s", $user_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }

    if ($left_referrals >= $setting_left_ref && $right_referrals  >=  $setting_right_ref &&  $direct_referrals >= $setting_direct_ref) {
        return true;
    } else {
        return false;
    }
}

function bmp_distribute_calculate_commission($user_key)
{
    global $wpdb;
    $returnarray = array();

    $bmp_manage_payout = get_option('bmp_manage_payout');

    $pair1 = $bmp_manage_payout['bmp_pair1'];
    $pair2 = $bmp_manage_payout['bmp_pair2'];

    $leftquery = $wpdb->get_results($wpdb->prepare("SELECT  `lp`.`user_key` FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on `u`.`user_key`=`lp`.`user_key` Where `lp`.`parent_key` = %s AND u.sponsor_key=%s  AND lp.commission_status = '0' AND u.payment_status = '1' ORDER BY u.id LIMIT %d", $user_key, $user_key, $pair1)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    $left_position_no = $wpdb->num_rows;

    if ($left_position_no >= $pair1) {
        $rightquery = $wpdb->get_results($wpdb->prepare("SELECT  `rp`.`user_key` FROM {$wpdb->prefix}bmp_rightposition as rp join {$wpdb->prefix}bmp_users as u on `u`.`user_key`=`rp`.`user_key` Where `rp`.`parent_key` = %s AND u.sponsor_key=%s AND rp.commission_status = '0' AND u.payment_status = '1' ORDER BY u.id LIMIT %d", $user_key, $user_key, $pair2)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

        $right_position_no = $wpdb->num_rows;

        if ($right_position_no >= $pair2) {
            // $returnarray[] = bmp_insert_pair_commission($leftquery, $rightquery, $user_key);
        }
    }

    //check users from right leg tabl

    $rightquery = $wpdb->get_results($wpdb->prepare("SELECT  rp.user_key FROM {$wpdb->prefix}bmp_rightposition as rp join {$wpdb->prefix}bmp_users as u on u.user_key=rp.user_key Where rp.parent_key = %s AND rp.commission_status = '0' AND u.sponsor_key=%s AND u.payment_status = '1' ORDER BY u.id LIMIT %d", $user_key, $user_key, $pair1)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    $right_position_no = $wpdb->num_rows;

    if ($right_position_no >= $pair1) {
        //check users from left leg table

        $leftquery = $wpdb->get_results($wpdb->prepare("SELECT  lp.user_key FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key = %s AND lp.commission_status = '0' AND u.sponsor_key=%s AND u.payment_status = '1' ORDER BY u.id LIMIT %d", $user_key, $user_key, $pair2)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        $left_position_no = $wpdb->num_rows;

        if ($left_position_no >= $pair2) {
            //mark users as paid and update commission table with child ids
            // $returnarray[] = bmp_insert_pair_commission($leftquery, $rightquery, $user_key);
        }
    }
    return $returnarray;
}

function bmp_getPair($leftcount, $rightcount)
{
    $bmp_manage_payout = get_option('bmp_manage_payout');

    $pair1 = $bmp_manage_payout['bmp_pair1'];
    $pair2 = $bmp_manage_payout['bmp_pair2'];

    $leftpair = (int)($leftcount / $pair1);
    $rightpair = (int)($rightcount / $pair2);

    if ($leftpair <= $rightpair)
        $pair = $leftpair;
    else
        $pair = $rightpair;

    $leftbalance = $leftcount - ($pair * $pair1);
    $rightbalance = $rightcount - ($pair * $pair2);

    $returnarray['leftbal'] = $leftbalance;
    $returnarray['rightbal'] = $rightbalance;
    $returnarray['pair'] = $pair;

    return $returnarray;
}

function bmp_getReferralCommissionById($user_id)
{
    global $wpdb;
    $refferal_comm = $wpdb->get_var($wpdb->prepare("SELECT SUM(amount) AS reff_comm FROM {$wpdb->prefix}bmp_referral_commission WHERE sponsor_id = %d AND payout_id = 0 GROUP BY sponsor_id", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $refferal_comm;
}

function bmp_getUserIdByUsername($username)
{
    global $wpdb;
    $id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM {$wpdb->prefix}bmp_users WHERE user_name = %s", $username)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $id;
}
function bmp_getuseridbykey($key)
{
    global $wpdb;
    $id = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM {$wpdb->prefix}bmp_users WHERE user_key = %s", $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $id;
}

function bmp_getUsernameByUserId($user_id)
{
    global $wpdb;
    $username = $wpdb->get_var($wpdb->prepare("SELECT user_name FROM {$wpdb->prefix}bmp_users WHERE user_id = %d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $username;
}
function bmp_getUserInfoByKey($key)
{
    global $wpdb;
    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE user_key = %s", $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $user;
}

function bmp_getUsername($key)
{
    global $wpdb;
    $username = $wpdb->get_var($wpdb->prepare("SELECT user_name FROM {$wpdb->prefix}bmp_users WHERE user_key = %s", $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $username;
}

function bmp_checkKey($key)
{
    global $wpdb;
    $user_key = $wpdb->get_var($wpdb->prepare("SELECT user_key FROM {$wpdb->prefix}bmp_users WHERE user_key = %s", $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    if (!$user_key) {
        return false;
    } else {
        return true;
    }
}

function bmp_get_current_user_key()
{
    global $current_user, $wpdb;
    $username = $current_user->user_login;
    $user_key = $wpdb->get_var($wpdb->prepare("SELECT user_key FROM {$wpdb->prefix}bmp_users WHERE user_name = %s", $username)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $user_key;
}

function bmp_get_user_key($user_id)
{
    global $wpdb;
    $user_key = $wpdb->get_var($wpdb->prepare("SELECT user_key FROM {$wpdb->prefix}bmp_users WHERE user_id = %d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $user_key;
}

function bmp_getproducprice($user_id)
{
    global $wpdb;
    $product_price = $wpdb->get_var($wpdb->prepare("SELECT product_price FROM {$wpdb->prefix}bmp_users WHERE user_id = %d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $product_price;
}

function bmp_get_epin_price($user_key = '')
{
    global $wpdb;
    $epin_price = $wpdb->get_var($wpdb->prepare("SELECT epin_price FROM {$wpdb->prefix}bmp_epins WHERE user_key = %s AND `type`=%s", $user_key, 'regular')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return !empty($epin_price) ? $epin_price : 0;
}

function bmp_get_parent_key_by_userid($user_id)
{
    global $wpdb;
    $parent_key = $wpdb->get_var($wpdb->prepare("SELECT parent_key FROM {$wpdb->prefix}bmp_users WHERE user_id = %d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $parent_key;
}

function bmp_get_sponsor_key_by_userid($user_id)
{
    global $wpdb;
    $sponsor_key = $wpdb->get_var($wpdb->prepare("SELECT sponsor_key FROM {$wpdb->prefix}bmp_users WHERE user_id = %d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $sponsor_key;
}

function bmpPrice($price = 0)
{
    global $wpdb;
    $currency = get_option('bmp_manage_general');
    $currency = isset($currency['bmp_currency']) ? $currency['bmp_currency'] : 'USD';
    $currency_symbol = $wpdb->get_var($wpdb->prepare("SELECT symbol FROM {$wpdb->prefix}bmp_currency WHERE iso3 = %s", $currency)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $currency_symbol . $price;
}
function bmp_insert_refferal_commision($user_id = '')
{
    global $wpdb;
    $date = current_time('mysql');
    $bmp_manage_payout_setting = get_option('bmp_manage_payout');
    $refferal_amount = isset($bmp_manage_payout_setting['bmp_referral_commission_amount']) ? sanitize_text_field(wp_unslash($bmp_manage_payout_setting['bmp_referral_commission_amount'])) : 0.00;
    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $sponsor_key = $row->sponsor_key;
    $child_id = $row->user_id;
    if ($bmp_manage_payout_setting['bmp_referral_commission_type'] == 'percentage') {
        $refferal_amount = bmp_get_epin_price($sponsor_key) * $refferal_amount / 100;
    }

    if ($sponsor_key != 0) {
        $sponsor = $wpdb->get_row($wpdb->prepare("SELECT user_id FROM {$wpdb->prefix}bmp_users WHERE user_key=%s", $sponsor_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
        $sponsor_user_id = $sponsor->user_id;
        $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_referral_commission SET date_notified=%s, sponsor_id=%d, child_id=%d, amount=%f, payout_id=%d", $date, $sponsor_user_id, $child_id, $refferal_amount, 0)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    }
}

function bmp_admin_reset_data_function()
{
    global $wpdb;
    $tables = array(
        "{$wpdb->prefix}bmp_users",
        "{$wpdb->prefix}bmp_leftposition",
        "{$wpdb->prefix}bmp_rightposition",
        "{$wpdb->prefix}bmp_payout",
        "{$wpdb->prefix}bmp_referral_commission",
        "{$wpdb->prefix}bmp_epins",
    );

    foreach ($tables as $table) {
        $wpdb->query("TRUNCATE " . $table); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange, WordPress.DB.PreparedSQL.NotPrepared
    }

    return true;
}

function bmp_epin_exist($epin)
{
    global $wpdb;

    if (empty($epin)) {
        return false;
    }
    $myepin = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$wpdb->prefix}bmp_epins WHERE epin_no=%s AND status=%s", $epin, '1')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if (!empty($myepin)) {
        return true;
    } else {
        return false;
    }
}

function bmp_generateKey()
{
    global $wpdb;
    $characters = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
    $length = 9;
    do {
        $keys = array();
        while (count($keys) < $length) {
            $x = wp_rand(0, count($characters) - 1);
            if (!in_array($x, $keys))
                $keys[] = $x;
        }

        // extract each key from array
        $random_chars = '';
        foreach ($keys as $key)
            $random_chars .= $characters[$key];

        // display random key
        $haskey = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$wpdb->prefix}bmp_users WHERE user_key=%s", $random_chars)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    } while ($haskey > 0);

    return $random_chars;
}

function bmp_get_page_id($page)
{
    $page = apply_filters('bmp_get_' . $page . '_page_id', get_option('bmp_' . $page . '_page_id'));
    return $page ? absint($page) : -1;
}

function bmp_create_page($slug, $option = '', $page_title = '', $page_content = '', $post_parent = 0)
{
    global $wpdb;

    $option_value = get_option($option);

    if ($option_value > 0 && ($page_object = get_post($option_value))) {
        if ('page' === $page_object->post_type && !in_array($page_object->post_status, array('pending', 'trash', 'future', 'auto-draft'))) {
            // Valid page is already in place

            return $page_object->ID;
        }
    }

    if (strlen($page_content) > 0) {
        // Search for an existing page with the specified page content (typically a shortcode)
        $valid_page_found = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' ) AND post_content LIKE %s LIMIT 1;", "%{$page_content}%")); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    } else {
        // Search for an existing page with the specified page slug
        $valid_page_found = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }

    $valid_page_found = apply_filters('bmp_create_page_id', $valid_page_found, $slug, $page_content);

    if ($valid_page_found) {
        if ($option) {
            update_option($option, $valid_page_found);
        }

        return $valid_page_found;
    }

    // Search for a matching valid trashed page
    if (strlen($page_content) > 0) {
        // Search for an existing page with the specified page content (typically a shortcode)
        $trashed_page_found = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_content LIKE %s LIMIT 1;", "%{$page_content}%")); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    } else {
        // Search for an existing page with the specified page slug
        $trashed_page_found = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }

    if ($trashed_page_found) {
        $page_id   = $trashed_page_found;
        $page_data = array(
            'ID'          => $page_id,
            'post_status' => 'publish',
        );
        wp_update_post($page_data);
    } else {
        $page_data = array(
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => 1,
            'post_name'      => $slug,
            'post_title'     => $page_title,
            'post_content'   => $page_content,
            'post_parent'    => $post_parent,
            'comment_status' => 'closed',
        );

        $page_id   = wp_insert_post($page_data);
        update_post_meta($page_id, 'is_bmp_page', true);
    }

    if ($option) {
        update_option($option, $page_id);
    }

    return $page_id;
}

// mail functions 

function bmp_payout_generated_mail($user_id, $amount, $payout_id)
{
    global $wpdb;

    $user_info = get_userdata($user_id);
    $siteownwer = get_bloginfo('name');
    $bmp_manage_email = get_option('bmp_manage_email');
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";

    $subject = $bmp_manage_email['bmp_runpayout_email_subject'];
    $message = nl2br(htmlspecialchars($bmp_manage_email['bmp_runpayout_email_message']));
    $message = str_replace('[firstname]', $user_info->first_name, $message);
    $message = str_replace('[lastname]', $user_info->last_name, $message);
    $message = str_replace('[email]', $user_info->user_email, $message);
    $message = str_replace('[username]', $user_info->user_login, $message);
    $message = str_replace('[amount]', $amount, $message);
    $message = str_replace('[payoutid]', $payout_id, $message);
    $message = str_replace('[sitename]', $siteownwer, $message);
    wp_mail(get_option('admin_email'), $subject, $message, $headers);
    wp_mail($user_info->user_email, $subject, $message, $headers);
}

// If apply for with drawal From Front End

function bmp_withdrawal_initiated_mail($user_id, $comment, $payout_id)
{
    global $wpdb;

    $row = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE `payout_id` = %d AND user_id=%d", $payout_id, $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    $user_info = get_userdata($user_id);

    $siteownwer = get_bloginfo('name');
    $bmp_manage_email = get_option('bmp_manage_email');

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    $headers .= "From: " . get_option('admin_email') . "<" . get_option('admin_email') . ">" . "\r\n";
    $subject = $bmp_manage_email['bmp_withdrawalInitiate_email_subject'];
    $message = nl2br(htmlspecialchars($bmp_manage_email['bmp_withdrawalInitiate_email_message']));
    $message = str_replace('[firstname]', $user_info->first_name, $message);
    $message = str_replace('[lastname]', $user_info->last_name, $message);
    $message = str_replace('[email]', $user_info->user_email, $message);
    $message = str_replace('[username]', $user_info->user_login, $message);
    $message = str_replace('[amount]', $row->capped_amt, $message);
    $message = str_replace('[mode]', $row->payment_mode, $message);
    $message = str_replace('[comment]', $comment, $message);
    $message = str_replace('[payoutid]', $payout_id, $message);
    $message = str_replace('[sitename]', $siteownwer, $message);
    wp_mail(get_option('admin_email'), $subject, $message, $headers);
    wp_mail($user_info->user_email, $subject, $message, $headers);
}

// mail functions 

function bmp_base_name_information()
{
    echo '<meta name="bmp_adminajax" content="' . esc_html(admin_url('admin-ajax.php')) . '" />';
    echo '<meta name="bmp_base_url" content="' . esc_html(site_url()) . '" />';
    echo '<meta name="bmp_author_url" content="https://www.letscms.com" />';
}

function bmp_add_query_vars($aVars)
{
    $aVars[] = "key";
    $aVars[] = "parent_key";
    $aVars[] = "position";
    return $aVars;
}

function bmp_add_rewrite_rules($aRules)
{
    $newrules = array();
    $newrules['/downlines/([^/]+)/?$'] = 'index.php?pagename=downlines&key=$matches[1]';
    $newrules['/register/([^/]+)/([^/]+)/?$'] = 'index.php?pagename=register&parent_key=$matches[1]&position=$matches[2]';

    $finalrules = $newrules + $aRules;
    return $finalrules;
}

function bmp_user_referral_commission($user_id)
{
    global $wpdb;
    $referral_commission = $wpdb->get_var($wpdb->prepare("SELECT SUM(amount) as total FROM {$wpdb->prefix}bmp_referral_commission WHERE sponsor_id=%d and payout_id!=0", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return ($referral_commission > 0) ? $referral_commission : '0';
}

function bmp_referral_by_commission_payout($payout_id, $user_id)
{
    global $wpdb;
    if ($user_id) {
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_referral_commission where payout_id=%d AND sponsor_id=%d", $payout_id, $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    } else {
        $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_referral_commission where payout_id=%d", $payout_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }
    return $results;
}

function bmp_payout_summary_by_amount_payout($payout_id)
{
    global $wpdb;
    $results = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout where id=%d", $payout_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_user_personal_detail_by_userid($user_id)
{
    global $wpdb;
    $results = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_user_personal_detail_by_leftuser($user_key)
{
    global $wpdb;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $user_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_user_personal_detail_by_rightuser($user_key)
{
    global $wpdb;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_rightposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $user_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_user_payoutdetail($user_id)
{
    global $wpdb;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_get_sum_commissionamount($user_id)
{
    global $wpdb;
    $totalComm = $wpdb->get_var($wpdb->prepare("SELECT sum(total_amount) FROM {$wpdb->prefix}bmp_payout where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $totalComm = !empty($totalComm) ? bmpPrice($totalComm) : bmpPrice(0.00);
    return $totalComm;
}

function bmp_get_sum_referral_commission_amount($user_id)
{
    global $wpdb;
    $results = $wpdb->get_var($wpdb->prepare("SELECT sum(referral_commission_amount) FROM {$wpdb->prefix}bmp_payout where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $results = number_format($results, 2);
    return $results;
}

function bmp_get_sum_bonus_amount($user_id)
{
    global $wpdb;
    $results = $wpdb->get_var($wpdb->prepare("SELECT sum(bonus_amount) FROM {$wpdb->prefix}bmp_payout where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $results = number_format($results, 2);
    return $results;
}

function bmp_get_sum_total_amount($user_id)
{
    global $wpdb;
    $results = $wpdb->get_var($wpdb->prepare("SELECT sum(total_amount) FROM {$wpdb->prefix}bmp_payout where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $results = number_format($results, 2);
    return $results;
}

function bmp_get_sum_capped_amount($user_id)
{
    global $wpdb;
    $results = $wpdb->get_var($wpdb->prepare("SELECT sum(capped_amount) FROM {$wpdb->prefix}bmp_payout where user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $results = number_format($results, 2);
    return $results;
}

function bmp_pair_referral_by_commission_user_id_and_payout_id($payout_id, $user_id)
{
    global $wpdb;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_referral_commission where payout_id=%d AND sponsor_id=%d", $payout_id, $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_pair_summary_by_user_id_and_payout_id($payout_id, $user_id)
{
    global $wpdb;
    $results = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout where id=%d and user_id=%d", $payout_id, $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_payout_list_of_current_user()
{
    global $wpdb, $current_user;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE user_id=%d", $current_user->ID)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_epin_of_current_user()
{
    global $wpdb, $current_user;
    $user_key = $wpdb->get_var($wpdb->prepare("SELECT user_key FROM {$wpdb->prefix}bmp_users WHERE user_id=%d", $current_user->ID)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_epins WHERE user_key=%s", $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_left_user_count_by_user_key($user_key)
{
    global $wpdb, $current_user;
    $total = $wpdb->get_var($wpdb->prepare("SELECT count(lp.user_key) as total FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $user_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $total;
}

function bmp_right_user_count_by_user_key($user_key)
{
    global $wpdb, $current_user;
    $total = $wpdb->get_var($wpdb->prepare("SELECT count(lp.user_key) as total FROM {$wpdb->prefix}bmp_rightposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $user_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $total;
}

function bmp_user_account_detail_of_current_user()
{
    global $wpdb, $current_user;
    $bmp_user_data = array();
    $bmp_user = bmp_user_personal_detail_by_userid($current_user->ID);
    $bmp_user_data['user_name'] = $bmp_user->user_name;
    $bmp_user_data['user_key'] = $bmp_user->user_key;
    $bmp_user_data['parent_key'] = $bmp_user->parent_key;
    $bmp_user_data['sponsor_key'] = $bmp_user->sponsor_key;
    $bmp_user_data['position'] = $bmp_user->position;
    $bmp_user_data['payment_status'] = $bmp_user->payment_status;
    $bmp_user_data['left_count'] = bmp_left_user_count_by_user_key($bmp_user->user_key);
    $bmp_user_data['right_count'] = bmp_right_user_count_by_user_key($bmp_user->user_key);
    return $bmp_user_data;
}

function bmp_user_left_downlines_of_current_user()
{
    global $wpdb, $current_user;
    $user_data = array();
    $bmp_user = bmp_user_personal_detail_by_userid($current_user->ID);
    $results = $wpdb->get_results($wpdb->prepare("SELECT lp.user_key FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $bmp_user->user_key, $bmp_user->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    foreach ($results as $result) {
        $user_data[] = bmp_getUserInfoByKey($result->user_key);
    }
    return $user_data;
}

function bmp_user_right_downlines_of_current_user()
{
    global $wpdb, $current_user;
    $user_data = array();
    $bmp_user = bmp_user_personal_detail_by_userid($current_user->ID);
    $results = $wpdb->get_results($wpdb->prepare("SELECT lp.user_key FROM {$wpdb->prefix}bmp_rightposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $bmp_user->user_key, $bmp_user->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    foreach ($results as $result) {
        $user_data[] = bmp_getUserInfoByKey($result->user_key);
    }
    return $user_data;
}

function bmp_user_left_downlines_by_key($key)
{
    global $wpdb, $current_user;
    $results = $wpdb->get_var($wpdb->prepare("SELECT count(lp.user_key) as total FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $key, $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_user_right_downlines_by_key($key)
{
    global $wpdb, $current_user;
    $results = $wpdb->get_var($wpdb->prepare("SELECT count(lp.user_key) as total FROM {$wpdb->prefix}bmp_rightposition as lp join {$wpdb->prefix}bmp_users as u on u.user_key=lp.user_key Where lp.parent_key=%s AND u.sponsor_key=%s", $key, $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}
function bmp_user_my_total_earnings()
{
    global $wpdb, $current_user;
    $user_data = array();
    $commission_amount = 0;
    $referral_commission_amount = 0;
    $bonus_amount = 0;
    $total_amount = 0;
    $capped_amount = 0;
    $cap_limit = 0;
    $tax = 0;
    $service_charge = 0;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE user_id=%d", $current_user->ID)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    foreach ($results as $result) {
        $commission_amount += $result->commission_amount;
        $referral_commission_amount += $result->referral_commission_amount;
        $bonus_amount += $result->bonus_amount;
        $total_amount += $result->total_amount;
        $capped_amount += $result->capped_amount;
        if (!empty($result->cap_limit)) {
            $cap_limit += $result->cap_limit;
        }
        $tax += $result->tax;
        $service_charge += $result->service_charge;
    }

    $user_data['commission_amount'] = $commission_amount;
    $user_data['referral_commission_amount'] = $referral_commission_amount;
    $user_data['bonus_amount'] = $bonus_amount;
    $user_data['total_amount'] = $total_amount;
    $user_data['capped_amount'] = $capped_amount;
    $user_data['cap_limit'] = $cap_limit;
    $user_data['tax'] = $tax;
    $user_data['service_charge'] = $service_charge;
    return $user_data;
}

function bmp_user_referral_commission_data($payout_id)
{
    global $wpdb, $current_user;

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_referral_commission WHERE sponsor_id=%d AND payout_id=%d", $current_user->ID, $payout_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $results;
}

function bmp_user_payout_detail_of_current_user($payout_id = "")
{
    global $wpdb, $current_user;

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE id=%d", $payout_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $results;
}

function bmp_user_payout_summary_data($payout_id)
{
    global $wpdb, $current_user;

    $results = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE user_id=%d AND id=%d", $current_user->ID, $payout_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    return $results;
}

function bmp_user_check_validate_function()
{
    global $wpdb, $current_user;
    $roles = (array) $current_user->roles;

    if (!is_user_logged_in()) {
        echo '<div class="container"><div class="user_error">' . esc_html__('You are not the Binary Mlm Plan Member. So you are not eligible to access this page.', 'binary-mlm-plan');
        echo  '</div></div>';
        die;
    } else if ((isset($current_user->caps['administrator']) && $current_user->caps['administrator'] == 1)) {
        return true;
    } else if (!in_array('bmp_user', $roles)) {
        echo '<div class="container"><div class="user_error">' . esc_html__('You are not the Binary Mlm Plan Member. So you are not eligible to access this page.', 'binary-mlm-plan');
        echo  '</div></div>';
        die;
    }
}

function bmp_user_check_payout_function()
{
    global $wpdb, $current_user;
    if (isset($_GET['id']) && !empty($_GET['id'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $id = sanitize_text_field(wp_unslash($_GET['id'])); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    } else {
        $id = 0;
    }
    $var_payout = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}bmp_payout WHERE id=%d AND user_id=%d", $id, $current_user->ID)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if ($var_payout) {
    } else {
        echo '<div class="container"><div class="user_error">' . esc_html__('Data not found.', 'binary-mlm-plan');
        echo  '</div></div>';
        die;
    }
}

function bmp_admin_user_account_detail_of_current_user($user_id)
{
    global $wpdb, $current_user;
    $bmp_user_data = array();
    $bmp_user = bmp_user_personal_detail_by_userid($user_id);
    $bmp_user_data['user_name'] = $bmp_user->user_name;
    $bmp_user_data['user_key'] = $bmp_user->user_key;
    $bmp_user_data['parent_key'] = $bmp_user->parent_key;
    $bmp_user_data['sponsor_key'] = $bmp_user->sponsor_key;
    $bmp_user_data['position'] = $bmp_user->position;
    $bmp_user_data['payment_status'] = $bmp_user->payment_status;
    $bmp_user_data['left_count'] = bmp_left_user_count_by_user_key($bmp_user->user_key);
    $bmp_user_data['right_count'] = bmp_right_user_count_by_user_key($bmp_user->user_key);

    return $bmp_user_data;
}

function bmp_admin_user_my_total_earnings($user_id)
{
    global $wpdb, $current_user;
    $user_data = array();
    $commission_amount = 0;
    $referral_commission_amount = 0;
    $bonus_amount = 0;
    $total_amount = 0;
    $capped_amount = 0;
    $cap_limit = 0;
    $tax = 0;
    $service_charge = 0;
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    foreach ($results as $result) {
        $commission_amount += $result->commission_amount;
        $referral_commission_amount += $result->referral_commission_amount;
        $bonus_amount += $result->bonus_amount;
        $total_amount += $result->total_amount;
        $capped_amount += $result->capped_amount;
        if (!empty($result->cap_limit)) {
            $cap_limit += $result->cap_limit;
        }
        $tax += $result->tax;
        $service_charge += $result->service_charge;
    }

    $user_data['commission_amount'] = $commission_amount;
    $user_data['referral_commission_amount'] = $referral_commission_amount;
    $user_data['bonus_amount'] = $bonus_amount;
    $user_data['total_amount'] = $total_amount;
    $user_data['capped_amount'] = $capped_amount;
    $user_data['cap_limit'] = $cap_limit;
    $user_data['tax'] = $tax;
    $user_data['service_charge'] = $service_charge;

    return $user_data;
}

function bmp_admin_user_left_downlines_of_current_user($user_id)
{
    global $wpdb, $current_user;
    $user_data = array();
    $bmp_user = bmp_user_personal_detail_by_userid($user_id);
    $results = $wpdb->get_results($wpdb->prepare("SELECT  `lp`.`user_key` FROM {$wpdb->prefix}bmp_leftposition as lp join {$wpdb->prefix}bmp_users as u on `u`.`user_key`=`lp`.`user_key` Where `lp`.`parent_key` = %s AND u.sponsor_key=%s", $bmp_user->user_key, $bmp_user->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    foreach ($results as $result) {
        $user_data[] = bmp_getUserInfoByKey($result->user_key);
    }
    return $user_data;
}

function bmp_admin_user_right_downlines_of_current_user($user_id)
{
    global $wpdb, $current_user;
    $user_data = array();
    $bmp_user = bmp_user_personal_detail_by_userid($user_id);
    $results = $wpdb->get_results($wpdb->prepare("SELECT  `lp`.`user_key` FROM {$wpdb->prefix}bmp_rightposition as lp join {$wpdb->prefix}bmp_users as u on `u`.`user_key`=`lp`.`user_key` Where `lp`.`parent_key` = %s AND u.sponsor_key=%s", $bmp_user->user_key, $bmp_user->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    foreach ($results as $result) {
        $user_data[] = bmp_getUserInfoByKey($result->user_key);
    }
    return $user_data;
}

function bmp_admin_payout_list_of_current_user($user_id)
{
    global $wpdb, $current_user;

    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_payout WHERE user_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $results;
}

function bmp_mlm_deactivate_function()
{
    global $wpdb;
    $install = new BMP_Install;
    $tables = $install->get_tables();

    foreach ($tables as $table) {
        $sql = "DROP TABLE IF EXISTS $table";
        $wpdb->query($sql); // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }

    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '%bmp_%';"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    // Delete users & usermeta.

    $wp_roles = new WP_Roles();
    $wp_roles->remove_role("bmp_user");
    session_destroy();

    // pages delete
    $results = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta where meta_key='is_bmp_page' AND meta_value='1'"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    foreach ($results as $result) {
        wp_delete_post($result->post_id);
    }

    // menu delete
    $results = $wpdb->get_results("SELECT post_id FROM {$wpdb->prefix}postmeta where meta_key='_menu_item_classes' AND meta_value LIKE '%bmp%'"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    foreach ($results as $result) {
        wp_delete_post($result->post_id);
    }
}

// admin payout list function 
function bmp_admn_user_payout_list_function()
{
    $user_id = isset($_GET['user_id']) ? esc_attr(sanitize_text_field(wp_unslash($_GET['user_id']))) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $payouts_list = bmp_admin_payout_list_of_current_user($user_id); ?>
    <div class="container" id="bmp_user_payouts">
        <div class="row">
            <div class="col-md-12 table-p">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My payouts List', 'binary-mlm-plan'); ?></h4>
                <table class="table table-striped " id="payoutsList">
                    <thead class="table-dark">
                        <tr>
                            <th><?php echo esc_html__('Payout Id', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Referral Commission', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Cap Limit', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Tax', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Service Charge', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Total Amount', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Action', 'binary-mlm-plan'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($payouts_list as $payout_list) { ?>
                            <tr>
                                <td><?php echo esc_attr($payout_list->id); ?></td>
                                <td><?php echo esc_attr(bmp_getUsernameByUserId($payout_list->user_id)); ?></td>
                                <td><?php echo esc_attr($payout_list->referral_commission_amount); ?></td>
                                <td><?php echo !empty($payout_list->cap_limit) ? esc_attr($payout_list->cap_limit) : 0; ?></td>
                                <td><?php echo esc_attr($payout_list->tax); ?></td>
                                <td><?php echo esc_attr($payout_list->service_charge); ?></td>
                                <td><?php echo esc_attr($payout_list->total_amount); ?></td>
                                <td>
                                    <a href="<?php echo esc_url(admin_url() . 'admin.php?page=bmp-payout-reports&user_id=' . esc_attr($payout_list->user_id) . '&payout_id=' . esc_attr($payout_list->id)); ?>"><?php echo esc_html__('View', 'binary-mlm-plan'); ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<?php
}
function bmp_admin_user_downlines_list_function()
{
    $user_id = isset($_GET['user_id']) ? esc_attr(sanitize_text_field(wp_unslash($_GET['user_id']))) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $left_downlines = bmp_admin_user_left_downlines_of_current_user($user_id);
    $right_downlines = bmp_admin_user_right_downlines_of_current_user($user_id);
?>
    <div class="container" id="bmp_user_downlines">
        <div class="row">
            <div class="col-md-6 table-b">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Left Downlinesss', 'binary-mlm-plan'); ?></h4>

                <table class="table table-striped" id="leftDownlines">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <td><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></td>
                            <td><?php echo esc_html__('User Key', 'binary-mlm-plan'); ?></td>
                            <td><?php echo esc_html__('Payment Status', 'binary-mlm-plan'); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($left_downlines as $left_downline) { ?>
                            <tr>
                                <td><?php echo esc_attr($left_downline->user_name); ?> </td>
                                <td><?php echo esc_attr($left_downline->user_key); ?></td>
                                <td><?php echo ($left_downline->payment_status == 1) ? esc_html__('Paid', 'binary-mlm-plan') : esc_html__('UnPaid', 'binary-mlm-plan'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <div class="col-md-6 table-b">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Right Downlines', 'binary-mlm-plan'); ?></h4>

                <table class="table table-striped" id="rightDownlines">
                    <thead class="table-dark">
                        <tr>
                            <td><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></td>
                            <td><?php echo esc_html__('User Key', 'binary-mlm-plan'); ?></td>
                            <td><?php echo esc_html__('Payment Status', 'binary-mlm-plan'); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($right_downlines as $right_downline) { ?>
                            <tr>
                                <td><?php echo esc_attr($right_downline->user_name); ?> </td>
                                <td><?php echo esc_attr($right_downline->user_key); ?></td>
                                <td><?php echo ($right_downline->payment_status == 1) ? esc_html__('Paid', 'binary-mlm-plan') : esc_html__('UnPaid', 'binary-mlm-plan'); ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
<?php
}

function bmp_admin_user_account_detail_function()
{
    $user_id = isset($_GET['user_id']) ? esc_attr(sanitize_text_field(wp_unslash($_GET['user_id']))) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $account_detail = bmp_admin_user_account_detail_of_current_user($user_id);
    $my_earning = bmp_admin_user_my_total_earnings($user_id);
?>
    <div class="container" id="bmp_user_detail">
        <div class="row">
            <div class="col-md-6 table-b">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Personal Detail', 'binary-mlm-plan'); ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['user_name']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('User Key', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['user_key']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Parent Key', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['parent_key']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Sponsor Key', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['sponsor_key']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Position', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['position']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Payment Status', 'binary-mlm-plan'); ?></th>
                            <td><?php echo ($account_detail['payment_status'] == '1') ? esc_html__('Paid', 'binary-mlm-plan') : esc_html__('Unpaid', 'binary-mlm-plan'); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Left Position Members', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['left_count']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Right Position Members', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['right_count']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-md-6 table-b">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Personal Earnings', 'binary-mlm-plan'); ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th><?php echo esc_html__('Refferal Commission', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($my_earning['referral_commission_amount']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Capped Amount', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($my_earning['total_amount']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Cap Limit', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($my_earning['cap_limit']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Tax', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($my_earning['tax']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Service Charge', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($my_earning['service_charge']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Total Amount', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($my_earning['total_amount']); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
}

function bmp_user_downlines_list_function()
{
    $left_downlines = bmp_user_left_downlines_of_current_user();
    $right_downlines = bmp_user_right_downlines_of_current_user(); ?>
    <div class="container mt-sm-3" id="bmp_user_downlines">
        <div class="row arrng-col-gap">
            <div class="col-md-6 table-p arrang-col">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Left Downliness', 'binary-mlm-plan'); ?></h4>

                <table class="table table-striped" id="leftDownlines">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('User Key', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Payment Status', 'binary-mlm-plan'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($left_downlines as $left_downline) { ?>
                            <tr>
                                <td><?php echo esc_attr($left_downline->user_name); ?> </td>
                                <td><?php echo esc_attr($left_downline->user_key); ?></td>
                                <td><?php echo ($left_downline->payment_status == 1) ? esc_html__('Paid', 'binary-mlm-plan') : esc_html__('UnPaid', 'binary-mlm-plan'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
            <div class="col-md-6 table-p mt-sm-3 mt-md-0 arrang-col">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Right Downlines', 'binary-mlm-plan'); ?></h4>

                <table class="table table-striped" id="rightDownlines">
                    <thead>

                        <tr>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('User Key', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Payment Status', 'binary-mlm-plan'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($right_downlines as $right_downline) { ?>
                            <tr>
                                <td><?php echo esc_attr($right_downline->user_name); ?> </td>
                                <td><?php echo esc_attr($right_downline->user_key); ?></td>
                                <td><?php echo ($right_downline->payment_status == 1) ? esc_html__('Paid', 'binary-mlm-plan') : esc_html__('UnPaid', 'binary-mlm-plan'); ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<?php
}

function bmp_user_account_detail_function()
{
    $account_detail = bmp_user_account_detail_of_current_user();
    $my_earning = bmp_user_my_total_earnings(); ?>
    <div class="container" id="bmp_user_detail">
        <div class="row arrng-col-gap">
            <div class="col-12 table-p mb-3">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Personal Detail', 'binary-mlm-plan'); ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['user_name']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('User Key', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['user_key']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Parent Key', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['parent_key']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Sponsor Key', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['sponsor_key']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Position', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['position']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Payment Status', 'binary-mlm-plan'); ?></th>
                            <td><?php echo ($account_detail['payment_status'] == '1') ? esc_html__('Paid', 'binary-mlm-plan') : esc_html__('Unpaid', 'binary-mlm-plan'); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Left Position Members', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['left_count']); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Right Position Members', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr($account_detail['right_count']); ?></td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="col-12 table-p mt-sm-3 mt-md-0 mb-3">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Personal Earnings', 'binary-mlm-plan'); ?></h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th><?php echo esc_html__('Refferal Commission', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr(bmpPrice($my_earning['referral_commission_amount'])); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Capped Amount', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr(bmpPrice($my_earning['capped_amount'])); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Cap Limit', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr(bmpPrice($my_earning['cap_limit'])); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Tax', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr(bmpPrice($my_earning['tax'])); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Service Charge', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr(bmpPrice($my_earning['service_charge'])); ?></td>
                        </tr>
                        <tr>
                            <th><?php echo esc_html__('Total Amount', 'binary-mlm-plan'); ?></th>
                            <td><?php echo esc_attr(bmpPrice($my_earning['total_amount'])); ?></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
}
function bmp_admin_payout_detail_function()
{
    global $wpdb;
    if (isset($_GET['payout_id']) && !empty($_GET['payout_id'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $payout_id = esc_attr(sanitize_text_field(wp_unslash($_GET['payout_id']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $payout_referral = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_referral_commission WHERE payout_id=%d", $payout_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching 
    } else if (isset($_GET['user_id']) && !empty($_GET['user_id'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $user_id = esc_attr(sanitize_text_field(wp_unslash($_GET['user_id']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $payout_referral = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_referral_commission WHERE sponsor_id=%d", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching 
    } else {
        $payout_referral = [];
    }

?>
    <div class="wrap">
        <div class="row">
            <div class="col-md-12">
                <h4 class="bg-secondary text-white p-2"><?php echo esc_html__('Referral Commission  Detail', 'binary-mlm-plan'); ?></h4>

                <table class="table table-hover table-striped" id="payoutReferral">
                    <thead class="table-dark">
                        <th><?php echo esc_html__('Sponsor', 'binary-mlm-plan'); ?></th>
                        <th><?php echo esc_html__('Childs', 'binary-mlm-plan'); ?></th>
                        <th><?php echo esc_html__('Amount', 'binary-mlm-plan'); ?></th>
                        <th><?php echo esc_html__('Date', 'binary-mlm-plan'); ?></th>
                    </thead>
                    <tbody>
                        <?php foreach ($payout_referral as $payout_referrals) { ?>
                            <tr>
                                <td><?php echo esc_attr(bmp_getUsernameByUserId($payout_referrals->sponsor_id)); ?></td>
                                <td><?php echo esc_attr(bmp_getUsernameByUserId($payout_referrals->child_id)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_referrals->amount)); ?></td>
                                <td><?php echo esc_attr(gmdate('F j, Y', strtotime($payout_referrals->date_notified))); ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
<?php
}
function bmp_admin_bonus_details_function()
{
    global $wpdb;
    if (isset($_GET['payout_id']) && !empty($_GET['payout_id'])) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        $payout_id = esc_attr(sanitize_text_field(wp_unslash($_GET['payout_id']))); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    } else {
        $payout_id = 0;
    }

    $payout_summary = bmp_payout_summary_by_amount_payout($payout_id); ?>
    <div class="wrap">
        <div class="row">
            <div class="col-md-12">
                <h4 class="bg-secondary text-white p-2"><?php echo esc_html__('Payout Summary', 'binary-mlm-plan'); ?> <?php echo ' - ' . esc_attr(bmp_getUsernameByUserId($payout_summary->user_id)); ?></h4>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tbody>
                            <?php if ($payout_summary) { ?>
                                <tr class="table-active">
                                    <th scope="row"><?php echo esc_html__('Referral Commisssion Amount', 'binary-mlm-plan'); ?></th>
                                    <td><?php echo esc_attr(bmpPrice($payout_summary->referral_commission_amount)); ?></td>
                                </tr>

                                <tr class="table-active">
                                    <th scope="row"><?php echo esc_html__('Cap Limit', 'binary-mlm-plan'); ?></th>
                                    <td><?php echo !empty($payout_summary->cap_limit) ? esc_attr(bmpPrice($payout_summary->cap_limit)) : 0; ?></td>
                                </tr>
                                <tr class="table-active">
                                    <th scope="row"><?php echo esc_html__('Service Charge Amount', 'binary-mlm-plan'); ?></th>
                                    <td><?php echo !empty($payout_summary->service_charge) ? esc_attr(bmpPrice($payout_summary->service_charge)) : 0; ?></td>
                                </tr>
                                <tr class="table-active">
                                    <th scope="row"><?php echo esc_html__('Tax Amount', 'binary-mlm-plan'); ?></th>
                                    <td><?php echo !empty($payout_summary->tax) ? esc_attr(bmpPrice($payout_summary->tax)) : 0; ?></td>
                                </tr>
                                <tr class="table-active">
                                    <th scope="row"><?php echo esc_html__('Total Amount', 'binary-mlm-plan'); ?></th>
                                    <td><?php echo esc_attr(bmpPrice($payout_summary->total_amount)); ?></td>
                                </tr>

                            <?php  } else { ?>
                                <tr>
                                    <td colspan="4" class="text-center"><?php echo esc_html__('There is no availabale.', 'binary-mlm-plan'); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
<?php
}
function bmp_user_payout_detail_function($payout_id = NULL)
{
    if ($payout_id == NULL || $payout_id == "") {
        $payout_id = 0;
    }
    $payout_detail = bmp_user_payout_detail_of_current_user($payout_id);
    $my_referral_data = bmp_user_referral_commission_data($payout_id); ?>
    <div class="wrap" id="bmp_user_downlines">
        <div class="row">
            <div class="col-12 table-p mb-3">
                <h4 class="bg-secondary p-2 text-white "><?php echo esc_html__('Commission Details', 'binary-mlm-plan'); ?></h4>
                <table class="table table-striped" id="frontpayoutsList">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('User', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Commission', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Service Charge', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Tax', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Net Amount', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Date', 'binary-mlm-plan'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($payout_detail as $payout_details) { ?>
                            <tr>
                                <td><?php echo esc_attr(bmp_getUsernameByUserId($payout_details->user_id)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_details->commission_amount)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_details->service_charge)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_details->tax)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_details->capped_amount)); ?></td>
                                <td><?php echo esc_attr(gmdate('F j, Y', strtotime($payout_details->date))); ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-12 table-p mb-3">
                <h4 class="bg-secondary p-2 text-white "><?php echo esc_html__('Referral Commission Details', 'binary-mlm-plan'); ?></h4>
                <table class="table table-striped" id="payoutReferral">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Amount', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('date', 'binary-mlm-plan'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($my_referral_data as $my_referrals_data) { ?>
                            <tr>
                                <td><?php echo esc_attr(bmp_getUsernameByUserId($my_referrals_data->sponsor_id)); ?> </td>
                                <td><?php echo esc_attr($my_referrals_data->amount); ?> </td>
                                <td><?php echo esc_attr(gmdate('F j, Y', strtotime($my_referrals_data->date_notified))); ?></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
}

function bmp_user_payout_list_function()
{
    $payouts_list = bmp_payout_list_of_current_user();
    $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
    $request_uri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';
    $current_url = $http . '://' . $host . $request_uri;

?>
    <div class="container mt-sm-3" id="bmp_user_payouts">
        <div class="row">
            <div class="col-md-12 table-p">
                <h4 class="bg-secondary p-2"><?php echo esc_html__('My Payouts List', 'binary-mlm-plan'); ?></h4>
                <table class="table table-striped " id="frontpayoutsList">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('Payout Id', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('User Name', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Referral Commission', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Cap Limit', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Tax', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Service Charge', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Total Amount', 'binary-mlm-plan'); ?></th>
                            <th><?php echo esc_html__('Action', 'binary-mlm-plan'); ?></th>
                        </tr>
                    </thead>
                    <?php if ($payouts_list) { ?>
                        <?php foreach ($payouts_list as $payout_list) { ?>
                            <tr>
                                <td><?php echo esc_attr($payout_list->id); ?></td>
                                <td><?php echo esc_attr(bmp_getUsernameByUserId($payout_list->user_id)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_list->commission_amount)); ?></td>
                                <td><?php echo !empty($payout_list->cap_limit) ? esc_attr(bmpPrice($payout_list->cap_limit)) : 0; ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_list->tax)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_list->service_charge)); ?></td>
                                <td><?php echo esc_attr(bmpPrice($payout_list->total_amount)); ?></td>
                                <td><a href="<?php echo esc_url($current_url); ?>?payout-id=<?php echo esc_attr($payout_list->id); ?>"><?php echo esc_html__('View', 'binary-mlm-plan'); ?></a></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>

            </div>
        </div>
    </div>
<?php
}

/* To add a value in custom columns added */

function bmp_front_register_function()
{
    global $wpdb;
    $jsonarray = array();
    $jsonarray['status'] = true;

    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $jsonarray['error']['bmp_first_name_message'] = esc_html__('Nonce verification failed', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    } else {
        $firstname = isset($_POST['bmp_first_name']) ? sanitize_text_field(wp_unslash($_POST['bmp_first_name'])) : '';
        $lastname = isset($_POST['bmp_last_name']) ? sanitize_text_field(wp_unslash($_POST['bmp_last_name'])) : '';
        $username = isset($_POST['bmp_username']) ? sanitize_text_field(wp_unslash($_POST['bmp_username'])) : '';
        $password = isset($_POST['bmp_password']) ? sanitize_text_field(wp_unslash($_POST['bmp_password'])) : '';
        $confirm_password = isset($_POST['bmp_confirm_password']) ? sanitize_text_field(wp_unslash($_POST['bmp_confirm_password'])) : '';
        $email = isset($_POST['bmp_email']) ? sanitize_text_field(wp_unslash($_POST['bmp_email'])) : '';
        $sponsor = isset($_POST['bmp_sponsor_id']) ? sanitize_text_field(wp_unslash($_POST['bmp_sponsor_id'])) : '';
        $telephone = isset($_POST['bmp_phone']) ? sanitize_text_field(wp_unslash($_POST['bmp_phone'])) : '';
        $position = isset($_POST['bmp_position']) ? sanitize_text_field(wp_unslash($_POST['bmp_position'])) : '';
        $bmp_epin = isset($_POST['bmp_epin']) ? sanitize_text_field(wp_unslash($_POST['bmp_epin'])) : '';
        $parent_key = isset($_POST['parent_key']) ? sanitize_text_field(wp_unslash($_POST['parent_key'])) : '';
    }

    if (empty($firstname)) {
        $jsonarray['error']['bmp_first_name_message'] = esc_html__('First Name could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }
    if (empty($lastname)) {
        $jsonarray['error']['bmp_last_name_message'] = esc_html__('Last Name could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if (empty($username)) {
        $jsonarray['error']['bmp_username_message'] = esc_html__('Userame could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if ($password != $confirm_password) {
        $jsonarray['error']['bmp_confirm_password_message'] = esc_html__('Confirm Password does not Match', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if (empty($email)) {
        $jsonarray['error']['bmp_email_message'] = esc_html__('Email could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    } else if (!is_email($email)) {
        $jsonarray['error']['bmp_email_message'] = esc_html__("E-mail address is invalid.", 'binary-mlm-plan');
        $jsonarray['status'] = false;
    } else if (email_exists($email)) {
        $jsonarray['error']['bmp_email_message'] = esc_html__("E-mail address is already in use.", 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if (empty($sponsor)) {
        $jsonarray['error']['bmp_sponsor_message'] = esc_html__('Sponsor could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if (empty($telephone)) {
        $jsonarray['error']['bmp_phone_message'] = esc_html__('Phone could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if (empty($position)) {
        $jsonarray['error']['bmp_position_message'] = esc_html__('Position could Not be empty', 'binary-mlm-plan');
        $jsonarray['status'] = false;
    }

    if (empty($jsonarray['error'])) {

        $sponsor_key = $wpdb->get_var($wpdb->prepare("SELECT `user_key` FROM {$wpdb->prefix}bmp_users WHERE `user_id` = %d", $sponsor)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

        $sponsor_parent_key = $sponsor_key;
        if (!empty($parent_key) && $parent_key != '') {
            $parent_key = $parent_key;
        } else {
            do {
                $sponsor_key_value = $wpdb->get_var($wpdb->prepare("SELECT `user_key` FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s AND position = %s", $sponsor_parent_key, $position)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

                $num = $wpdb->num_rows;
                if ($num) {
                    $sponsor_parent_key = $sponsor_key_value;
                }
            } while ($num == 1);

            $parent_key = $sponsor_parent_key;
        }

        $user_key = bmp_generateKey();

        $user = array(
            'user_login' => $username,
            'user_pass' => $password,
            'first_name' => $firstname,
            'last_name' => $lastname,
            'user_email' => $email
        );

        $user_id = wp_insert_user($user);
        $user = new WP_User($user_id);
        $user->set_role('bmp_user');
        add_user_meta($user_id, 'bmp_first_name', $firstname);
        add_user_meta($user_id, 'bmp_last_name', $lastname);
        add_user_meta($user_id, 'bmp_username', $username);
        add_user_meta($user_id, 'bmp_sponsor_id', $sponsor);
        add_user_meta($user_id, 'bmp_phone', $telephone);
        add_user_meta($user_id, 'bmp_position', $position);

        $sponsor_key = bmp_get_user_key($sponsor);

        if ($wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            $wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_users (user_id, user_name, user_key, parent_key, sponsor_key, position, payment_date, payment_status, product_price) VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %f)", $user_id, $username, $user_key, $parent_key, $sponsor_key, $position, current_time('mysql'), '0', 0.00)
        )) {

            if ($position == 'left') {
                $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                    $wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_leftposition (parent_key, user_key) VALUES (%s, %s)", $parent_key, $user_key)

                );
            } else if ($position == 'right') {

                $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                    $wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_rightposition (parent_key, user_key) VALUES (%s, %s)", $parent_key, $user_key)
                );
            }

            while ($parent_key != '0') {
                $result = $wpdb->get_row($wpdb->prepare("SELECT COUNT(*) num, parent_key, position FROM {$wpdb->prefix}bmp_users WHERE user_key = %s", $parent_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                if ($result->num == 1) {
                    if ($result->parent_key != '0') {
                        if ($result->position == 'right') {
                            $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                                $wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_rightposition (parent_key, user_key) VALUES (%s, %s)", $result->parent_key, $user_key)
                            );
                        } else {

                            $wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                                $wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_leftposition (parent_key, user_key) VALUES (%s, %s)", $result->parent_key, $user_key)
                            );
                        }
                    }
                    $parent_key = $result->parent_key;
                } else {
                    $parent_key = '0';
                }
            }

            if (!empty($bmp_epin)) {
                $un_used_epin = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_epins WHERE epin_no = %s and status = %s", $bmp_epin, '0')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                if (!empty($un_used_epin)) {
                    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}bmp_epins SET user_key = %s, status = %s, date_used = %s WHERE epin_no = %s", $user_key, '1', gmdate('Y-m-d'), $bmp_epin)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                    if ($un_used_epin->type == 'regular') {
                        $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}bmp_users SET payment_status = %s, product_price = %f WHERE user_id = %d", '1', $un_used_epin->epin_price, $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                        if (bmp_eligibility_check_for_commission($sponsor_key)) {
                            bmp_insert_refferal_commision($user_id);
                        }
                    }
                }
            }
        }

        $jsonarray['status'] = true;
        $jsonarray['message'] = esc_html__('Binary User has been created successfully.', 'binary-mlm-plan');
    }

    echo json_encode($jsonarray);
    wp_die();
}

/////////////////join network ////////////////
function bmp_front_join_network_function()
{
    global $wpdb, $current_user;
    $jsonjoinarray = array();
    $jsonjoinarray['status'] = false;
    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $jsonjoinarray['error']['bmp_epin_join_message'] = esc_html__('Nonce verification failed', 'binary-mlm-plan');
        $jsonjoinarray['status'] = false;
    } else {
        $sponsor = isset($_POST['bmp_join_sponser']) ? sanitize_text_field(wp_unslash($_POST['bmp_join_sponser'])) : '';
        $position = isset($_POST['bmp_join_leg']) ? sanitize_text_field(wp_unslash($_POST['bmp_join_leg'])) : '';
        $epin = isset($_POST['bmp_join_epin']) ? sanitize_text_field(wp_unslash($_POST['bmp_join_epin'])) : '';
        if (empty($epin)) {
            $jsonjoinarray['error']['bmp_epin_join_message'] = esc_html__('ePin could Not be empty', 'binary-mlm-plan');
            $jsonjoinarray['status'] = false;
        } else if (!empty($epin) && bmp_epin_exist($epin)) {
            $jsonjoinarray['error']['bmp_epin_join_message'] = esc_html__('ePin Already Used', 'binary-mlm-plan');
            $jsonjoinarray['status'] = false;
        }

        if (empty($sponsor)) {
            $jsonjoinarray['error']['bmp_join_sponsor_message'] = esc_html__('Sponsor could Not be empty', 'binary-mlm-plan');
            $jsonjoinarray['status'] = false;
        }
        if (empty($position)) {
            $jsonjoinarray['error']['bmp_join_position_message'] = esc_html__('Position could Not be empty', 'binary-mlm-plan');
            $jsonjoinarray['status'] = false;
        }
    }

    if (empty($jsonjoinarray['error']) && !empty($current_user->ID)) {


        $user_id = $current_user->ID;

        $user_key = bmp_generateKey();

        $sponsor_key = bmp_get_user_key($sponsor);
        $sponsor_parent_key = $sponsor_key;
        if (!empty($parent_key) && $parent_key != '') {
            $parent_key = $parent_key;
        } else {

            do {

                $sponsor_key_value = $wpdb->get_var($wpdb->prepare("SELECT `user_key` FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s AND position = %s", $sponsor_parent_key, $position)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                $num = $wpdb->num_rows;
                if (!empty($sponsor_key_value)) {
                    $sponsor_parent_key = $sponsor_key_value;
                }
            } while (!empty($sponsor_key_value));

            $parent_key = $sponsor_parent_key;
        }


        //insert the data into wp_mlm_user table
        if ($wpdb->query( // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            $wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_users (user_id, user_name, user_key, parent_key, sponsor_key, position,payment_date,payment_status,product_price)
            VALUES (%d, %s, %s, %s, %s, %s, %s, %s, %f)", $user_id, $current_user->user_login, $user_key, $parent_key, $sponsor_key, $position, current_time('mysql'), '0', 0.00)
        )) {

            $user = get_user_by('id', $user_id);
            $user->set_role('bmp_user');
            //entry on Left and Right Leg tables
            if ($position == 'left') {

                $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_leftposition (parent_key, user_key) VALUES (%s, %s)", $parent_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            } else if ($position == 'right') {

                $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_rightposition (parent_key, user_key) VALUES(%s, %s)", $parent_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            }

            // while the parent_key equal 0

            while ($parent_key != '0') {
                $result = $wpdb->get_row($wpdb->prepare("SELECT COUNT(*) as num, parent_key, position FROM {$wpdb->prefix}bmp_users WHERE user_key = %s", $parent_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                if ($result->num == 1) {
                    if ($result->parent_key != '0') {
                        if ($result->position == 'right') {

                            $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_rightposition (parent_key,user_key) VALUES (%s, %s)", $result->parent_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                        } else {

                            $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}bmp_leftposition (parent_key,user_key) VALUES (%s, %s)", $result->parent_key, $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                        }
                    }
                    $parent_key = $result->parent_key;
                } else {
                    $parent_key = '0';
                }
            }
            if (!empty($epin)) {
                $un_used_epin = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_epins WHERE epin_no = %s and status=%s", $epin, '0')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                if (!empty($un_used_epin)) {
                    $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}bmp_epins SET user_key=%s, status=%s, date_used=%s WHERE epin_no = %s", $user_key, '1', gmdate('Y-m-d'), $epin)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                    if ($un_used_epin->type == 'regular') {
                        $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}bmp_users SET payment_status=%s, product_price=%f WHERE user_id=%d", '1', $un_used_epin->epin_price, $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                        if (bmp_eligibility_check_for_commission($sponsor_key)) {
                            bmp_insert_refferal_commision($user_id);
                        }
                    }
                }
            }
        }

        $jsonjoinarray['status'] = true;
        $jsonjoinarray['message'] = esc_html__('Binary User has been join successfully.', 'binary-mlm-plan');
    }
    echo json_encode($jsonjoinarray);
    wp_die();
}
//////////////. user name exist ////////////////

function bmp_username_exist_function()
{
    global $wpdb;

    $json = array();
    $json['status'] = false;
    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Nonce verification failed', 'binary-mlm-plan') . '</span>';
        echo json_encode($json);
        wp_die();
    }
    $username = isset($_POST['username']) ? sanitize_text_field(wp_unslash($_POST['username'])) : '';
    $bmp_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE user_name=%s", $username)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if (!empty($bmp_user)) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('User Already Exist. Please try another user', 'binary-mlm-plan') . '</span>';
    } elseif (empty($username)) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('User Name could not be empty.', 'binary-mlm-plan') . '</span>';
    } else {
        $json['status'] = true;
        $json['message'] = '<span style="color:green">' . esc_html__('Congratulation!This username is avaiable.', 'binary-mlm-plan') . '</span>';
    }

    echo json_encode($json);

    wp_die();
}
///// user emaik exist /////

function bmp_position_exist_function()
{
    global $wpdb;
    $json = array();
    $json['status'] = false;

    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Nonce verification failed', 'binary-mlm-plan') . '</span>';
        echo json_encode($json);
        wp_die();
    }

    $position = isset($_POST['position']) ? sanitize_text_field(wp_unslash($_POST['position'])) : '';
    $sponsor = isset($_POST['sponsor']) ? sanitize_text_field(wp_unslash($_POST['sponsor'])) : '';

    $sponsor_key = $wpdb->get_var($wpdb->prepare("SELECT `user_key` FROM {$wpdb->prefix}bmp_users WHERE `user_id` = %d", $sponsor)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    $sponsor_parent_key = $sponsor_key;

    $bmp_user_exist = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$wpdb->prefix}bmp_users` WHERE `sponsor_key` = %s AND `position`=%s", $sponsor_parent_key, $position)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    if ($bmp_user_exist) {
        $json['status'] = true;
        $json['message'] = '<span style="color:red">' . esc_html__('Position Already Used by someone. Please try another Position', 'binary-mlm-plan') . '</span>';
    } else {
        if (!empty($position)) {
            $json['status'] = true;
            $json['message'] = '<span style="color:green">' . esc_html__('Congratulation! This position is avaiable.', 'binary-mlm-plan') . '</span>';
        } else {
            $json['status'] = false;
            $json['message'] = '<span style="color:red">' . esc_html__('Position Could not be empty.', 'binary-mlm-plan') . '</span>';
        }
    }
    echo json_encode($json);
    wp_die();
}
function bmp_email_exist_function()
{
    global $wpdb;
    $json = array();
    $json['status'] = false;
    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Nonce verification failed', 'binary-mlm-plan') . '</span>';
        echo json_encode($json);
        wp_die();
    }
    $email = isset($_POST['email']) ? sanitize_text_field(wp_unslash($_POST['email'])) : '';
    if (!empty($email)) {
        if (is_email($email)) {
            if (email_exists($email)) {
                $json['status'] = false;
                $json['message'] = '<span style="color:red">' . esc_html__('Email Already Used by someone. Please try another Email', 'binary-mlm-plan') . '</span>';
            } else {
                $json['status'] = true;
                $json['message'] = '<span style="color:green">' . esc_html__('Congratulation!This Email is avaiable.', 'binary-mlm-plan') . '</span>';
            }
        } else {
            $json['status'] = false;
            $json['message'] = '<span style="color:red">' . esc_html__('Email is not valid.', 'binary-mlm-plan') . '</span>';
        }
    } else {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Email could not be empty.', 'binary-mlm-plan') . '</span>';
    }

    echo json_encode($json);

    wp_die();
}
//////////////. user name exist ////////////////
function bmp_epin_exist_function()
{
    global $wpdb;

    $json = array();
    $json['status'] = false;
    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Nonce verification failed', 'binary-mlm-plan') . '</span>';
        echo json_encode($json);
        wp_die();
    }
    $epin = isset($_POST['epin']) ? sanitize_text_field(wp_unslash($_POST['epin'])) : '';
    $eping = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$wpdb->prefix}bmp_epins WHERE epin_no=%s AND status=%s", $epin, '0')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    if (!empty($eping)) {
        $json['status'] = true;
        $json['message'] = '<span style="color:green">' . esc_html__('Congratulation!This ePin is avaiable.', 'binary-mlm-plan') . '</span>';
    } else {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Epin Already Used or Not exist. Please try another ePin', 'binary-mlm-plan') . '</span>';
    }

    echo json_encode($json);

    wp_die();
}

//////// user password validate //////

function bmp_password_validation_function()
{

    global $wpdb;
    $json = array();
    $json['status'] = false;
    if (!isset($_POST['bmp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['bmp_nonce'])), 'bmp_nonce_action')) {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Nonce verification failed', 'binary-mlm-plan') . '</span>';
        echo json_encode($json);
        wp_die();
    }
    $password = isset($_POST['password']) ? sanitize_text_field(wp_unslash($_POST['password'])) : '';
    $confirm_password = isset($_POST['confirm_password']) ? sanitize_text_field(wp_unslash($_POST['confirm_password'])) : '';

    if ($password == $confirm_password) {
        $json['status'] = true;
        $json['message'] = '<span style="color:green">' . esc_html__('Congratulation! Password is valid.', 'binary-mlm-plan') . '</span>';
    } else {
        $json['status'] = false;
        $json['message'] = '<span style="color:red">' . esc_html__('Sorry Password does not match.', 'binary-mlm-plan') . '</span>';
    }

    echo json_encode($json);

    wp_die();
}

function bmp_level_based_childs($key, $level)
{
    global $wpdb;
    $childs = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s", $key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $childs;
}

function bmp_downlines($user_key)
{
    global $wpdb;
    $downlines = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$wpdb->prefix}bmp_users WHERE sponsor_key = %s", $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $downlines;
}
function bmp_autofill_position_parent_key($sponsor_parent_key)
{
    global $wpdb, $level;
    $level++;

    $childs = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s", $sponsor_parent_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching

    if ($wpdb->num_rows == 0) {
        return array('position' => 'left', 'parent_key' => esc_attr($sponsor_parent_key));
    } else if ($wpdb->num_rows == 1) {
        foreach ($childs as $child) {
            if ($child->position == 'left') {
                return array('position' => 'right', 'parent_key' => esc_attr($child->parent_key));
            } else if ($child->position == 'right') {
                return array('position' => 'left', 'parent_key' => esc_attr($child->parent_key));
            }
        }
    } else {
        $childs_count = pow(2, $level);
        $num_check = 0;

        foreach ($childs as $child) {

            $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s", $child->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
            $num_check += $wpdb->num_rows;
        }

        if ($childs_count == $num_check) {
            foreach ($childs as $child) {

                $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s", $child->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                if ($wpdb->num_rows == 2) {
                    return bmp_autofill_position_parent_key($child->user_key);
                }
            }
        } else {

            $all_childs = bmp_level_based_childs($sponsor_parent_key, $level);

            foreach ($childs as $child) {

                $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE parent_key = %s", $child->user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
                if ($wpdb->num_rows == 1 || $wpdb->num_rows == 0) {
                    return bmp_autofill_position_parent_key($child->user_key);
                }
            }
        }
    }
}


function bmp_frontend_script_function()
{
    wp_enqueue_script('jquery');
    wp_enqueue_style('bmpcss', BMP()->plugin_url() . '/assets/css/bmp.css', array(), time(), 'all');
    wp_enqueue_style('bmp_bootstrap', BMP()->plugin_url() . '/assets/css/bootstrap.css', array(), true, 'all');
    wp_enqueue_style('bmp_fs_css', BMP()->plugin_url() . '/assets/fontawesome/css/all.min.css', [], true, 'all');
    wp_enqueue_script('bootstrapjs', BMP()->plugin_url() . '/assets/js/bootstrap.min.js', [], true, true);
    wp_enqueue_script('bmp_mainjs', BMP()->plugin_url() . '/assets/js/main.js', ['jquery'], time(), true);
    wp_enqueue_script('bmp-fs-js', BMP()->plugin_url() . '/assets/fontawesome/js/all.min.js', array(), true, true);
}

function bmp_dataTable()
{
    wp_enqueue_script('jquery');
    wp_enqueue_style('bmp_dataTable_css', BMP()->plugin_url() . '/assets/datatable/datatables.css', time(), 'all');
    wp_enqueue_script('bmp_dataTable_js', BMP()->plugin_url() . '/assets/datatable/datatables.js', ['jquery'], true, true);
    wp_enqueue_script('bmp_dataTable', BMP()->plugin_url() . '/assets/js/dataTable.js', [], time(), true);
}
function bmp_genealogy_scripts()
{
    $data = bmp_get_all_members_array();
    $data  = json_encode($data);
    wp_enqueue_scripts('jquery');
    wp_enqueue_style('bmp_gen_css', BMP()->plugin_url() . '/assets/js/genealogy/genealogy.css', [], true, 'all');
    wp_enqueue_script('bmp-genboot-js', BMP()->plugin_url() . '/assets/js/genealogy/genealogy_boot.js', array('jquery'), true,  true);
    wp_enqueue_script('bmp-gen-js', BMP()->plugin_url() . '/assets/js/genealogy/genealogy_main.js', array('jquery'), time(), true);
    wp_localize_script('bmp-gen-js', 'genealogy_data', array($data));
}

function bmp_get_all_members_array($user_id = NULL)
{
    global $wpdb, $current_user;
    $members = array();
    $childs_array = array();
    $is_admin = false;

    if (isset($current_user->caps['bmp_user']) && $current_user->caps['bmp_user'] == 1) {
        $user_id = $current_user->ID;
        $root_user = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users WHERE user_id=%d ORDER BY position DESC LIMIT 1", $user_id)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    } else if (isset($current_user->caps['administrator']) && $current_user->caps['administrator'] == 1) {
        $is_admin = true;
        $root_user = $wpdb->get_row("SELECT * from {$wpdb->prefix}bmp_users WHERE parent_key='0' AND sponsor_key='0' LIMIT 1"); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    }

    if (!empty($root_user)) {
        $members = array(
            "name" => bmp_getUsername($root_user->user_key),
            "imageUrl" => bmp_get_profile_picture($root_user),
            "isPaid" => $root_user->payment_status,
            "userData" => array(
                'parent'        => ($root_user->parent_key) ? bmp_getUsername($root_user->parent_key) : esc_html__('Company', 'binary-mlm-plan'),
                'sponsor'       => ($root_user->sponsor_key) ? bmp_getUsername($root_user->sponsor_key) : esc_html__('Company', 'binary-mlm-plan'),
                'position'      =>  $root_user->position,
                'total_earning' => bmp_get_sum_commissionamount($root_user->user_id),
                'total_widral'  => 0,
                'downlines'     => bmp_downlines($root_user->user_key),
                'is_admin'      =>  $is_admin,
                'left_link'     => addMemberLink($root_user->user_key, 'left'),
                'right_link'    => addMemberLink($root_user->user_key, 'right'),
            ),
            "isLoggedUser" => ($current_user->ID == $root_user->user_id) ? true : false,
            "userKey" => $root_user->user_key,
            "children" => bmp_get_childs_data($root_user->user_key, $childs_array, $is_admin)
        );
    }
    return $members;
}

function bmp_get_childs_data($user_key, $childs_array = array(), $is_admin = NULL)
{
    global $wpdb;
    $user_childs = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}bmp_users as u WHERE parent_key=%s ORDER BY position DESC", $user_key)); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    if (!empty($user_childs)) {
        foreach ($user_childs as $keys => $child) {
            $childs_array[$keys] = array(
                "name" => bmp_getUsername($child->user_key),
                "imageUrl" => bmp_get_profile_picture($child),
                "isPaid" => $child->payment_status,
                "userData" => array(
                    'parent'        =>  bmp_getUsername($child->parent_key),
                    'sponsor'       =>  bmp_getUsername($child->sponsor_key),
                    'position'      =>  $child->position,
                    'total_earning' =>  bmp_get_sum_commissionamount($child->user_id),
                    'total_widral'  =>  0,
                    'downlines'     =>  bmp_downlines($child->user_key),
                    'is_admin'      =>  $is_admin,
                    'left_link'     => null,
                    'right_link'    => null,
                ),
                "isLoggedUser" => false,
                "userKey" => $child->user_key,
                "children" => bmp_get_childs_data($child->user_key, $childs_array, $is_admin)
            );
        }
    } else {
        $childs_array = '';
    }
    return $childs_array;
}

function bmp_get_profile_picture($user)
{
    $url = '';
    if (!empty($user)) {
        if ($user->payment_status == '1') {
            $url = BMP()->plugin_url() . '/image/paid.png';
        } else {
            $url = BMP()->plugin_url() . '/image/unpaid.png';
        }
    }
    return $url;
}

function bmp_get_top_user_key()
{
    global $wpdb;
    $top_user = $wpdb->get_var($wpdb->prepare("SELECT user_key FROM {$wpdb->prefix}bmp_users WHERE parent_key=%s AND sponsor_key=%s LIMIT 1", '0', '0')); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
    return $top_user;
}

function  addMemberLink($user_key, $position)
{
    $link = '';
    if ($position == 'left') {
        $link = get_site_url() . '/register/?k=' . esc_attr($user_key) . '&position=left';
    } else {
        $link = get_site_url() . '/register/?k=' . esc_attr($user_key) . '&position=right';
    }
    return $link;
}

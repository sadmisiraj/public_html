<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
class bmp_admin_users_list extends WP_List_Table
{

    /** Class constructor */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => __('id', 'binary-mlm-plan'),
            'plural'   => __('id', 'binary-mlm-plan'),
            'ajax'     => false

        ));
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'user_id' => array('user_id', true),
            'user_name' => array('user_name', true),
            'payment_status' => array('payment_status', true),
            'user_key' => array('user_key', true),
            'parent_key' => array('parent_key', true),
            'sponsor_key' => array('sponsor_key', true),
            'position' => array('position', true),

        );
        return $sortable_columns;
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'user_id':
            case 'user_name':
            case 'payment_status':
            case 'user_key':
            case 'parent_key':
            case 'sponsor_key':
            case 'position':
            case 'product_price':
            case 'pair_commission':
            case 'referral_commission':
            case 'action';
                return $item[$column_name];
            default:
                return esc_html__('Unknown column', 'binary-mlm-plan');
        }
    }

    function get_columns()
    {
        $columns = array(
            'user_id'    => __('User Id', 'binary-mlm-plan'),
            'user_name' => __('User Name', 'binary-mlm-plan'),
            'payment_status'    => __('Payment Status', 'binary-mlm-plan'),
            'user_key'    => __('User key', 'binary-mlm-plan'),
            'parent_key'    => __('Parent Key', 'binary-mlm-plan'),
            'sponsor_key'    => __('Sponsor Key', 'binary-mlm-plan'),
            'position'    => __('Position', 'binary-mlm-plan'),
            'referral_commission'    => __('Referral Commission', 'binary-mlm-plan'),
            'action'    => __('Action', 'binary-mlm-plan'),

        );

        return $columns;
    }


    function prepare_items()
    {

        global $wpdb;
        global $date_format;
        $per_page = 10;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        if (isset($_GET['orderby']) && isset($_GET['order'])) { //phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $orderby = sanitize_text_field(wp_unslash($_GET['orderby'])); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $order = sanitize_text_field(wp_unslash($_GET['order'])); //phpcs:ignore WordPress.Security.NonceVerification.Recommended
        } else {
            $orderby = 'id';
            $order = 'ASC';
        }
        $sql = "SELECT * FROM {$wpdb->prefix}bmp_users ORDER BY $orderby $order";
        $results = $wpdb->get_results($wpdb->prepare($sql), ARRAY_A); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared


        $i = 0;
        $listdata = array();
        $num = $wpdb->num_rows;
        if ($num > 0) {
            foreach ($results as $row) {
                $listdata[$i]['user_id'] = $row['user_id'];
                $listdata[$i]['user_name'] = $row['user_name'];
                $listdata[$i]['payment_status'] = ($row['payment_status']) ? 'Paid' : 'Un Paid';
                $listdata[$i]['user_key'] = $row['user_key'];
                $listdata[$i]['parent_key'] = $row['parent_key'];
                $listdata[$i]['sponsor_key'] = $row['sponsor_key'];
                $listdata[$i]['position'] = $row['position'];
                $listdata[$i]['referral_commission'] = bmp_user_referral_commission($row['user_id']);
                $listdata[$i]['action'] = '<a href="' . admin_url() . 'admin.php?page=bmp-user-reports&user_id=' . $row['user_id'] . '&user_key=' . $row['user_key'] . '">View</a>';
                $i++;
            }
        }

        $data = $listdata;

        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data, (($current_page - 1) * $per_page), $per_page);
        $this->items = $data;
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ));
    }
}

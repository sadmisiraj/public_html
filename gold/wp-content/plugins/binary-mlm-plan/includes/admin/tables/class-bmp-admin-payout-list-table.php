<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}


class bmp_admin_payout_list extends WP_List_Table
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
            'user_id'    => array('user_id', true),
            'date' => array('date', true),
            'commission_amount'    => array('commission_amount', true),
            'referral_commission_amount'    => array('referral_commission_amount', true),
            'total_amount'    => array('total_amount', true),

        );
        return $sortable_columns;
    }

    function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'user_id':
            case 'date':
            case 'commission_amount':
            case 'referral_commission_amount':
            case 'total_amount':
            case 'cap_limit':
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
            'date' => __('Date', 'binary-mlm-plan'),
            'commission_amount'    => __('Commission Amount', 'binary-mlm-plan'),
            'referral_commission_amount'    => __('Referral Commission Amount', 'binary-mlm-plan'),
            'total_amount'    => __('total amount', 'binary-mlm-plan'),
            'cap_limit'    => __('Cap Limit', 'binary-mlm-plan'),
            'action'    => __('Action', 'binary-mlm-plan'),
        );

        return $columns;
    }


    function prepare_items()
    {

        global $wpdb;
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

        $sql = "SELECT * FROM {$wpdb->prefix}bmp_payout ORDER BY $orderby $order";
        $results = $wpdb->get_results($sql, ARRAY_A); // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared

        $i = 0;
        $listdata = array();
        $num = $wpdb->num_rows;
        if ($num > 0) {
            foreach ($results as $row) {
                $listdata[$i]['user_id'] = $row['user_id'];
                $listdata[$i]['date'] = $row['date'];
                $listdata[$i]['commission_amount'] = ($row['commission_amount']) ? 'Paid' : 'Un Paid';
                $listdata[$i]['referral_commission_amount'] = isset($row['referral_commission_amount']) ? bmpPrice($row['referral_commission_amount']) : 0;
                $listdata[$i]['total_amount'] = bmpPrice($row['total_amount']);
                $listdata[$i]['cap_limit'] = !empty($row['cap_limit']) ? bmpPrice($row['cap_limit']) : 0;
                $listdata[$i]['action'] = '<a href="' . admin_url() . 'admin.php?page=bmp-payout-reports&payout_id=' . $row['id'] . '">View</a>';
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

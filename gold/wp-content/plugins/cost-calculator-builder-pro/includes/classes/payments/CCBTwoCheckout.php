<?php
// phpcs:ignoreFile
namespace cBuilder\Classes\Payments;

use cBuilder\Classes\CCBPayments;

class CCBTwoCheckout extends CCBPayments {
    public static function render() {
        $result = array(
            'success' => false,
            'status'  => 'success',
            'message' => esc_html__( 'Something went wrong', 'cost-calculator-builder-pro' ),
        );

        if ( empty( self::$params['token'] ) ) {
            $result['message'] = 'Invalid Token';
            return $result;
        }

        if ( empty( self::$paymentSettings['merchantCode'] ) || empty( self::$paymentSettings['privateKey'] ) ) {
            $result['message'] = 'Invalid API key';
            return $result;
        }

        self::placeOrder('fp=bkS&RA[0aH(2Oz]K%', array(
            'Country'           => 'br',
            'Currency'          => 'brl',
            'CustomerIP'        => '91.220.121.21',
            'ExternalReference' => 'CustOrderCatProd100',
            'Language'          => 'en',
            'BillingDetails'    => array(
                    'Address1'    => 'Test Address',
                    'City'        => 'LA',
                    'CountryCode' => 'BR',
                    'Email'       => 'customer@2Checkout.com',
                    'FirstName'   => 'Customer',
                    'FiscalCode'  => '056.027.963-98',
                    'LastName'    => '2Checkout',
                    'Phone'       => '556133127400',
                    'State'       => 'DF',
                    'Zip'         => '70403-900',
            ),
            "Items" => array(
                0 => array(
                    "Name"         =>  '123',
                    "Quantity"     => '1',
                    "IsDynamic"    => true,
                    "Tangible"     => false,
                    "PurchaseType" => "PRODUCT",
                    "Price"        => array(
                        "Amount" => '123.00',
                    )
                )
            ),
            "PaymentDetails" => array(
                'Type'          => 'CC',
                'Currency'      => 'USD',
                'CustomerIP'    => '91.220.121.21',
                "PaymentMethod" => array(
                    'CCID'               => '123',
                    'CardNumber'         => '6011111111111117',
                    'CardNumberTime'     => '12',
                    'CardType'           => 'discover',
                    'ExpirationMonth'    => '12',
                    'ExpirationYear'     => '2025',
                    'HolderName'         => 'John Doe',
                    'HolderNameTime'     => '12',
                    'RecurringEnabled'   => true,
                    'Vendor3DSReturnURL' => 'www.test.com',
                    'Vendor3DSCancelURL' => 'www.test.com',
                ),
            )
        ));

        return $result;
    }

    private static function placeOrder( $key, $post_json_encode ) {
        $post_json_encode = json_encode( $post_json_encode );
        $merchantCode = '254848243044';
        $date = gmdate('Y-m-d H:i:s', time() );
        $hash = hash_hmac( 'md5', strlen( $merchantCode ) . $merchantCode . strlen( $date ) . $date, $key );

        $header = [
            'Content-Type'	=> 'application/json',
            'Accept'		=> 'application/json',
            'X-Avangate-Authentication'	=> 'code="' . $merchantCode . '" date="' . $date . '" hash="' . $hash . '"'
        ];

        $response = wp_remote_post( 'https://api.avangate.com/rest/6.0/orders/', [
            'method'	=> 'POST',
            'timeout'	=> 120,
            'sslverify'	=> true,
            'headers'	=> $header,
            'body'		=> $post_json_encode,
        ] );

        if ( is_wp_error( $response ) ) {

            $error_message = $response->get_error_message();

            return [ 'error' => __( 'Could not connect' ) . ' ' . $error_message ];

        } else {

            $body = json_decode( $response['body'], true );

            return  $body;
        }
    }

    private static function getPaymentSettingsByCalculatorId( $calculator_id ) {
        $settings = get_option( 'stm_ccb_form_settings_' . $calculator_id );
        if ( false === $settings || ! array_key_exists( 'payment_cards', $settings ) ) {
            return array();
        }
        return $settings['paypal'];
    }

    private static function getUserIpAddr() {
        $ip = false;

        if ( ! empty( $_SERVER['HTTP_X_REAL_IP'] ) ) {
            $ip = filter_var( $_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP );
        } elseif ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            $ip = filter_var( $_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP );
        } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
            $ips = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
            if ( is_array( $ips ) ) {
                $ip = filter_var( $ips[0], FILTER_VALIDATE_IP );
            }
        } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
            $ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP );
        }

        $ip		  = false !== $ip ? $ip : '127.0.0.1';
        $ip_array = explode( ',', $ip );
        $ip_array = array_map( 'trim', $ip_array );

        if ( '::1' === $ip_array[0] || '127.0.0.1' === $ip_array[0] ) {
            $ip_ser = array( 'http://ipv4.icanhazip.com','http://v4.ident.me','http://bot.whatismyipaddress.com' );
            shuffle( $ip_ser );

            $ip_services = array_slice( $ip_ser, 0,1 );
            $ret         = wp_remote_get( $ip_services[0] );

            if ( ! is_wp_error( $ret ) ) {
                if ( isset( $ret['body'] ) ) {
                    return sanitize_text_field( $ret['body'] );
                }
            }
        }

        return sanitize_text_field( apply_filters( 'cf72ch_get_ip', $ip_array[0] ) );
    }
}

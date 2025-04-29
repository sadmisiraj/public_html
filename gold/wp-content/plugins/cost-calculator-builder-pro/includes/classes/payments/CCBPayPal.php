<?php
// phpcs:ignoreFile
namespace cBuilder\Classes\Payments;

use cBuilder\Classes\CCBPayments;
use cBuilder\Classes\Database\Orders as OrdersModel;
use cBuilder\Classes\Database\Payments;

class CCBPayPal extends CCBPayments {

	private static $BASE_SANDBOX = "https://api-m.sandbox.paypal.com";
	private static $BASE_LIVE    = "https://api-m.paypal.com";

	private static $MODE = 'sandbox';

	/**
	 * Generate payment url with order data
	 */
	public static function render() {
		$payment_url = '';
		if ( ! empty( self::$paymentSettings ) && self::$paymentSettings['enable'] ) {

			self::setMode( self::$paymentSettings['paypal_mode'] );

			$custom = '';
			$amount = number_format( self::$total, 2, '.', '' );
			$url    = ( 'live' === self::$paymentSettings['paypal_mode'] ) ? 'www.paypal.com' : 'www.sandbox.paypal.com';

			if ( isset( self::$params['order_id'] ) ) {
				Payments::update_payment_total_by_order_id( self::$params['order_id'], $amount );
			}

			$settings = get_option( 'stm_ccb_form_settings_' . self::$params['calcId'] );
			$home_url = empty( $_SERVER['HTTP_REFERER'] ) ? home_url() : $_SERVER['HTTP_REFERER'];
			$type     = $settings['thankYouPage']['type'];

			if ( in_array( $type, array( 'separate_page', 'custom_page' ), true ) ) {
				if ( 'custom_page' === $type ) {
					$home_url = $settings['thankYouPage']['custom_page_link'];
				}

				if ( 'separate_page' === $type ) {
					$page_id = $settings['thankYouPage']['page_id'];
					$page    = get_post( $page_id );

					$pos = strpos( $page->post_content, 'stm-thank-you-page' );
					if ( false === $pos ) {
						$updated_page = array(
							'ID'           => $page_id,
							'post_content' => $page->post_content . '[stm-thank-you-page id="' . self::$params['calcId'] . '"]',
						);

						wp_update_post( $updated_page );
					}

					$home_url = get_permalink( $settings['thankYouPage']['page_id'] );
					$url_pos  = strpos( $home_url, '&' );
					if ( false === $url_pos ) {
						$home_url = $home_url . '?order_id=' . self::$params['order_id'];
					} else {
						$home_url = $home_url . '&order_id=' . self::$params['order_id'];
					}
				}
			}

			$payer_info = array();
			$params     = array(
				'cmd'           => '_xclick',
				'business'      => self::$paymentSettings['paypal_email'],
				'item_name'     => self::$params['item_name'] ?? '',
				'amount'        => ! empty( $amount ) ? $amount : 1,
				'rm'            => 1,
				'return'        => $home_url,
				'notify_url'    => get_home_url() . '/?stm_ccb_check_ipn=1', //todo
				'currency_code' => self::$paymentSettings['currency_code'] ?? 'USD',
				'invoice'       => self::$params['order_id'],
				'order_id'      => self::$params['order_id'],
				'no_shipping'   => 1,
				'no_note'       => 1,
				'display'       => 1,
				'charset'       => 'UTF%2d8',
				'bn'            => 'PP%2dBuyNowBF',
			);

			/** customer info */
			if ( ! empty( self::$customer ) ) {
				$params['email']      = ! empty( self::$customer['email'] ) ? self::$customer['email'] : ( ! empty( self::$customer['your-email'] ) ? self::$customer['your-email'] : '' );
				$params['first_name'] = ! empty( self::$customer['name'] ) ? self::$customer['name'] : ( ! empty( self::$customer['your-name'] ) ? self::$customer['your-name'] : '' );

				$payer_info['email']      = $params['email'];
				$payer_info['first_name'] = $params['first_name'];

				$client_data = array_map(
					function( $value, $key ) {
						return $key . ':' . $value;
					},
					array_values( self::$customer ),
					array_keys( self::$customer )
				);

				$custom .= __( 'Customer', 'cost-calculator-builder-pro' );
				$custom .= ' - ' . implode( ' , ', $client_data ) . ';';
			}

			/** set order details */
			if ( null !== self::$order && is_object( self::$order ) && property_exists( self::$order, 'order_details' ) ) {

				$custom       .= __( 'Calculator', 'cost-calculator-builder-pro' ) . ' - ';
				$count_detail  = 0;
				$data          = json_decode( self::$order->order_details );
				$order_details = array();

				foreach ( $data as $item ) {
					if ( str_contains( $item->alias, 'repeater' ) ) {
						$item->title     = $item->groupTitle;
						$item->extraView = '';

						$order_details[] = $item;

						if ( count( $item->groupElements ) ) {
							foreach ( $item->groupElements as $child ) {
								$order_details[] = $child;
							}
						}
					} else {
						$order_details[] = $item;
					}
				}

				foreach ( $order_details as $detail_key => $detail ) {

					/** remove text field from send data */
					if ( 'text' === preg_replace( '/\_field_id.*/', '', $detail->alias ) ) {
						continue;
					}

					if ( isset( $detail->value ) ) {
						$summary_value = number_format( (float) $detail->value, 2, '.', '' );

						if ( property_exists( $detail, 'summary_view' ) && property_exists( $detail, 'extraView' ) ) {
							if ( 'show_label_not_calculable' === $detail->summary_view ) {
								$summary_value = $detail->extraView;
							} elseif ( 'show_label_calculable' === $detail->summary_view ) {
								$summary_value = '(' . $detail->extraView . ') ' . $summary_value;
							}
						}

						$custom .= $detail->title . ':' . $summary_value . ';';

						if ( $count_detail < 6 ) {
							$params[ 'on' . $detail_key ] = strlen( $detail->title ) > 60 ? substr( $detail->title, 0, 60 ) . '...' : $detail->title;
							$params[ 'os' . $detail_key ] = number_format( (float) $detail->value, 2, '.', '' );
							$count_detail++;
						}
					}
				}
			}

			$custom           = strlen( $custom ) > 256 ? substr( $custom, 0, 250 ) . '...' : $custom;
			$params['custom'] = $custom;

			if ( ! empty( self::$paymentSettings['integration_type'] ) ) {
				if ( 'rest' === self::$paymentSettings['integration_type'] ) {
					if ( empty( self::$paymentSettings['client_id'] ) || empty( self::$paymentSettings['client_secret'] ) ) {
						return array(
							'success' => false,
							'message' => 'Invalid API key',
						);
					}

					$payment_data = array(
						'intent'              => 'CAPTURE',
						'payer'               => array(
							'payment_method' => 'paypal',
							'payer_info'     => array(
								'email'      => $payer_info['email'] ?? '',
								'first_name' => $payer_info['first_name'] ?? '',
							),
						),
						'purchase_units'      => array(
							array(
								'amount' => array(
									'currency_code' => self::$paymentSettings['currency_code'] ?? 'USD',
									'value'         => ! empty( $amount ) ? $amount : 1,
								),
								'order_id'  => self::$params['order_id'],
								'custom_id' => self::$params['order_id'],
							),
						),
						'application_context' => array(
							'return_url' => ccb_remove_params_from_url( $home_url, array( 'token', 'PayerID' ) ),
							'cancel_url' => empty( $_SERVER['HTTP_REFERER'] ) ? home_url() : $_SERVER['HTTP_REFERER'],
						),
					);

					$accessToken  = self::generateAccessToken( self::$paymentSettings['client_id'], self::$paymentSettings['client_secret'] );
					$responseData = self::paypalCreateOrder( $accessToken, $payment_data );

					if ( ! empty( $responseData->links ) ) {
						foreach ( $responseData->links as $link ) {
							if ( $link->rel === 'approve' ) {
								$payment_url = $link->href;
							}
						}
					}
				} elseif ( 'legacy' === self::$paymentSettings['integration_type'] ) {
					if ( empty( self::$paymentSettings['paypal_email'] ) ) {
						return array(
							'success' => false,
							'message' => 'Invalid Paypal email',
						);
					}
					$payment_url = 'https://' . $url . '/cgi-bin/webscr?' . http_build_query( $params );
				}
			}
		}

		if ( empty( $payment_url ) ) {
			return array(
				'success' => false,
				'message' => 'Something went wrong',
			);
		}

		return array(
			'success' => true,
			'url'     => $payment_url,
		);
	}

	public static function check_payment( $ipn_response ) {
		$validate_ipn  = array( 'cmd' => '_notify-validate' );
		$validate_ipn += stripslashes_deep( $ipn_response );

		$params = array(
			'body'        => $validate_ipn,
			'sslverify'   => false,
			'timeout'     => 60,
			'httpversion' => '1.1',
			'compress'    => false,
			'decompress'  => false,
			'user-agent'  => 'paypal-ipn/',
		);

		$order = OrdersModel::get( 'id', $params['body']['invoice'] );
		if ( null === $order ) {
			header( 'HTTP/1.1 404 Not Found', true, 404 );
			exit;
		}
		$payment_settings = self::getPaymentSettingsByCalculatorId( $order->calc_id );
		$paypal_url       = ( 'live' === $payment_settings['paypal_mode'] ) ? 'www.paypal.com' : 'www.sandbox.paypal.com';
		$response_url     = "https://{$paypal_url}/cgi-bin/webscr";

		$response = wp_safe_remote_post( $response_url, $params );
		if ( is_wp_error( $response ) ) {
			header( 'HTTP/1.1 500 Response Error', true, 500 );
			exit;
		}

		if ( isset( $response['response']['code'] ) && ( 200 === $response['response']['code'] && ( strstr( $response['body'], 'VERIFIED' ) || strcmp( $response['response']['code'], 'VERIFIED' ) === 0 ) ) ) {
			$payment_data = array(
				'type'        => 'paypal',
				'transaction' => sanitize_text_field( $ipn_response['txn_id'] ),
				'currency'    => self::$paymentSettings['currency_code'] ?? 'USD',
				'notes'       => serialize( array_map( 'sanitize_text_field', $ipn_response ) ), //phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.serialize_serialize
			);

			CCBPayments::makePaid( $order->id, $payment_data );
			header( 'HTTP/1.1 200 OK' );
		} else {
			header( 'HTTP/1.1 500 Response Error', true, 500 );
		}
		exit;
	}

	private static function getPaymentSettingsByCalculatorId( $calculator_id ) {
		$settings = get_option( 'stm_ccb_form_settings_' . $calculator_id );
		if ( false === $settings || ! array_key_exists( 'paypal', $settings ) ) {
			return array();
		}
		return $settings['paypal'];
	}

	private static function generateAccessToken( $clientId, $clientSecret ) {
		$auth = base64_encode( "$clientId:$clientSecret" );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, self::getBaseByMode() . "/v1/oauth2/token" );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials" );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			"Authorization: Basic $auth"
		) );

		$response = curl_exec( $ch );
		curl_close( $ch );

		$data = json_decode( $response, true );
		return $data['access_token'] ?? null;
	}

	private static function handleResponse( $response ) {
		$jsonResponse   = json_decode( $response, true );
		$httpStatusCode = http_response_code();
		return array(
			'jsonResponse'   => $jsonResponse,
			'httpStatusCode' => $httpStatusCode,
		);
	}

	private static function paypalCreateOrder( $accessToken, $payload ) {
		$url = self::getBaseByMode() . "/v2/checkout/orders";

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $payload ) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Bearer ' . $accessToken,
		) );

		$response = curl_exec( $ch );
		if ( empty( $response ) ) {
			return null;
		};

		$responseData = json_decode( $response );
		curl_close($ch);

		return $responseData;
	}

	private static function setMode( $mode ) {
		self::$MODE = $mode;
	}

	private static function getBaseByMode() {
		return ( 'sandbox' === self::$MODE || empty( self::$MODE ) ) ? self::$BASE_SANDBOX : self::$BASE_LIVE;
	}

	public static function captureOrder( $id, $calc_id ) {
		self::$calculatorId = $calc_id;
		$paymentSettings	= self::getPaymentSettingsHandler( 'paypal' );
		if ( empty( $paymentSettings ) ) {
			return;
		}

		$accessToken = self::generateAccessToken( $paymentSettings['client_id'],$paymentSettings['client_secret'] );
		$url         = self::getBaseByMode() . "/v2/checkout/orders/$id/capture";

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, 1 ); //phpcs:ignore
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Authorization: Bearer ' . $accessToken ) ); //phpcs:warning WordPress.WP.AlternativeFunctions.curl_curl_setopt

		$response = curl_exec( $ch ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_exec
		curl_close( $ch ); //phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_close

		$data = json_decode( $response, true );

		if ( ! empty( $data['status'] ) && 'COMPLETED' === $data['status'] && ! empty( $data['purchase_units'][0]['payments']['captures'][0]['id'] ) ) {
			if ( ! empty( $data['purchase_units'][0]['payments']['captures'][0]['custom_id'] ) ) {
				$payment_data = array(
					'type'          => 'paypal',
					'transaction'   => sanitize_text_field( $data['purchase_units'][0]['payments']['captures'][0]['id'] ),
					'currency'      => $paymentSettings['currency_code'] ?? 'USD',
					'total'         => $data['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
					'no_order_data' => true,
				);

				CCBPayments::makePaid( $data['purchase_units'][0]['payments']['captures'][0]['custom_id'], $payment_data );
			}
		}
	}
}

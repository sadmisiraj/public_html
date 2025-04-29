<?php

namespace cBuilder\Classes;

use cBuilder\Classes\Database\Orders;
use cBuilder\Classes\Database\Orders as OrdersModel;
use cBuilder\Classes\Database\Payments as PaymentModel;


class CCBPayments {
	public static $total;
	public static $calculatorId     = array();
	public static $params           = array();
	public static $paymentSettings  = array();
	public static $settings         = array();
	public static $general_settings = array();
	public static $customer         = array();
	public static $order            = array();
	public static $payment          = array();
	public static $errors           = array(
		'no_payment'  => 'No payment method',
		'no_action'   => 'No action',
		'no_nonce'    => 'nonce',
		'no_calc_id'  => 'No calculator id',
		'no_settings' => 'No settings',
		'no_order'    => 'Order not found',
	);
	protected static $paymentMethod = '';
	protected static $actionType    = 'render';

	/** @var \string[][]
	 * CCBWooCheckout not used here for now
	 */
	protected static $availablePayments = array(
		array(
			'name'  => 'paypal',
			'class' => 'cBuilder\Classes\Payments\CCBPayPal',
		),
		array(
			'name'  => 'stripe',
			'class' => 'cBuilder\Classes\Payments\CCBStripe',
		),
		array(
			'name'  => 'cash_payment',
			'class' => 'cBuilder\Classes\Payments\CCBCashPayment',
		),
		array(
			'name'  => 'twoCheckout',
			'class' => 'cBuilder\Classes\Payments\CCBTwoCheckout',
		),
		array(
			'name'  => 'razorpay',
			'class' => 'cBuilder\Classes\Payments\CCBRazorPay',
		),
	);
	protected static $permittedActions  = array( 'ccb_payment' );
	protected static $paymentNonce      = 'ccb_payment';

	/**
	 * return payment class from $availablePayments
	 *
	 * @return string
	 */
	private static function getPaymentClass() {
		$error = array(
			'status'  => 'error',
			'success' => false,
			'message' => self::$errors['no_payment'],
		);

		if ( ! array_key_exists( 'method', self::$params ) || ( array_key_exists( 'method', self::$params ) && ! in_array( self::$params['method'], array_column( self::$availablePayments, 'name' ), true ) ) ) {
			wp_send_json( $error );
		}

		$paymentKey = array_search( self::$params['method'], array_column( self::$availablePayments, 'name' ), true );
		if ( false === $paymentKey ) {
			wp_send_json( $error );
		}

		if ( ! class_exists( self::$availablePayments[ $paymentKey ]['class'] ) ) {
			wp_send_json( $error );
		}

		return self::$availablePayments[ $paymentKey ]['class'];
	}

	/** render payment by cls */
	public static function renderPayment() {
		/** setPaymentData , generate all data */
		self::setPaymentData();

		$paymentCls = self::getPaymentClass();
		$result     = $paymentCls::{ self::$actionType }();

		wp_send_json( $result );
	}

	private static function validate() {
		$data = null;

		if ( isset( $_POST['data'] ) ) {
			$data = ccb_convert_from_btoa( $_POST['data'] );

			if ( ! ccb_is_convert_correct( $data ) ) {
				wp_send_json(
					array(
						'status'  => 'error',
						'success' => false,
						'message' => 'Invalid data',
					)
				);
			}
		}

		if ( is_string( $data ) ) {
			self::$params = json_decode( stripslashes( $data ), true );
			$order_id     = self::$params['order_id'] ?? '';
			$order_data   = CCBOrderController::get_orders_by_id( $order_id );
			$meta_data    = get_option( 'calc_meta_data_order_' . $order_id, array() );
			$calc_totals  = json_decode( $meta_data['totals'], true );
			$otherTotals  = json_decode( $meta_data['otherTotals'], true );

			self::$params['item_name']           = $order_data['calc_title'] ?? '';
			self::$params['calcTotals']          = $calc_totals ?? array();
			self::$params['calcTotalsConverted'] = $calc_totals ?? array();
			self::$params['otherTotals']         = $otherTotals ?? array();
		}

		/** check payment method */
		if ( ! array_key_exists( 'method', self::$params ) || ( array_key_exists( 'method', self::$params ) && ! in_array( self::$params['method'], array_column( self::$availablePayments, 'name' ), true ) ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_payment'],
				)
			);
		}

		self::$paymentMethod = self::$params['method'];

		/** check action */
		if ( ! array_key_exists( 'action', self::$params ) || ( array_key_exists( 'action', self::$params ) && ! in_array( self::$params['action'], self::$permittedActions, true ) ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_action'],
				)
			);
		}

		/** check nonce */
		if ( ! array_key_exists( 'nonce', self::$params ) || ( array_key_exists( 'nonce', self::$params ) && ! wp_verify_nonce( self::$params['nonce'], self::$paymentNonce ) ) ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_nonce'],
				)
			);
		}

		/** check calculator id */
		if ( ! array_key_exists( 'calcId', self::$params ) || ! self::$params['calcId'] ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_calc_id'],
				)
			);
		}

		if ( array_key_exists( 'action_type', self::$params ) && in_array( self::$params['action_type'], array( 'render', 'intent_payment' ), true ) ) {
			self::$actionType = self::$params['action_type'];
		}
	}

	/** set and validate send data */
	public static function setPaymentData( $send_to_email = true ) {
		self::validate();

		self::$calculatorId    = self::$params['calcId'];
		self::$settings        = self::getSettings();
		self::$paymentSettings = self::getPaymentSettings();
		self::$total           = self::getTotal();

		if ( ! self::$paymentSettings ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_settings'],
				)
			);
			wp_die();
		}

		if ( ! is_null( self::$total ) && intval( self::$total ) <= 0 && 'cash_payment' !== self::$params['method'] ) {
			wp_send_json(
				array(
					'success' => false,
					'status'  => 'error',
					'message' => __( 'Total must be more then 0', 'cost-calculator-builder-pro' ),
				)
			);
			wp_die();
		}

		if ( ! array_key_exists( 'order_id', self::$params ) || ! self::$params['order_id'] ) {
			wp_send_json(
				array(
					'success' => false,
					'status'  => 'error',
					'message' => self::$errors['no_order'],
				)
			);
			wp_die();
		}

		/** set payment method to order */
		self::$order = OrdersModel::get( 'id', self::$params['order_id'] );
		/** if order id exist, but order not found return error */
		if ( null === self::$order ) {
			wp_send_json(
				array(
					'status'  => 'error',
					'success' => false,
					'message' => self::$errors['no_order'],
				)
			);
		}

		self::$payment = PaymentModel::get( 'order_id', self::$params['order_id'] );

		if ( $send_to_email && 'razorpay' !== self::$paymentMethod ) {
			self::sendEmail();
		}

		/** if no payment , create */
		if ( null === self::$payment ) {
			self::createPayment();
		}

		self::$customer = self::getCustomerData();
		self::$payment  = self::updatePayment();

		do_action( 'ccb_payment_data_updated', self::$customer, self::$params, self::$order, self::$payment );
		self::updateOrder();
	}

	/** update order and payment rows statuses */
	public static function makePaid( $orderId, $paymentData, $d_totals = array(), $o_totals = array() ) {
		$orderId      = sanitize_text_field( $orderId );
		$totals       = isset( self::$params['calcTotals'] ) ? wp_json_encode( self::$params['calcTotals'] ) : array();
		$other_totals = isset( self::$params['otherTotals'] ) ? wp_json_encode( self::$params['otherTotals'] ) : array();

		if ( ! empty( $d_totals ) ) {
			$totals = wp_json_encode( $d_totals );
		}

		if ( ! empty( $o_totals ) ) {
			$other_totals = wp_json_encode( $o_totals );
		}

		$meta_data = array(
			'converted'   => self::$total,
			'totals'      => $totals,
			'otherTotals' => $other_totals,
		);

		if ( ! empty( $paymentData['no_order_data'] ) ) {
			unset( $paymentData['no_order_data'] );
		} else {
			update_option( 'calc_meta_data_order_' . $orderId, $meta_data, false );
		}

		try {
			if ( empty( $paymentData['status'] ) || PaymentModel::$completeStatus === $paymentData['status'] ) {
				OrdersModel::complete_order_by_id( $orderId );
			}

			$paymentData['order_id']   = $orderId;
			$paymentData['updated_at'] = wp_date( 'Y-m-d H:i:s' );
			$paymentData['paid_at']    = wp_date( 'Y-m-d H:i:s' );
			$paymentData['status']     = PaymentModel::$completeStatus;

			$payment = PaymentModel::get( 'order_id', $orderId );
			if ( null === $payment ) {
				/** if no payment , create */
				$paymentData['created_at'] = wp_date( 'Y-m-d H:i:s' );
				PaymentModel::insert( $paymentData );
			} else {
				/** update if row exist */
				PaymentModel::update( $paymentData, array( 'order_id' => $orderId ) );
			}
		} catch ( Exception $e ) {
			// log here
			header( 'Status: 500 Server Error' );
		}
	}

	/** set payment transaction ( id from payment system ) */
	public static function setPaymentTransaction( $orderId, $transaction, $notes = array() ) {
		$orderId     = sanitize_text_field( $orderId );
		$transaction = sanitize_text_field( $transaction );
		$paymentData = array(
			'transaction' => sanitize_text_field( $transaction ),
			'updated_at'  => wp_date( 'Y-m-d H:i:s' ),
		);

		if ( ! empty( $notes ) ) {
			$paymentData['notes'] = serialize( array_map( 'sanitize_text_field', $notes ) ); // phpcs:ignore
		}

		PaymentModel::update( $paymentData, array( 'order_id' => $orderId ) );
	}

	protected static function getCustomerData() {
		if ( null === self::$order || ! is_object( self::$order ) || ! property_exists( self::$order, 'form_details' ) ) {
			return array();
		}

		$formDetails = json_decode( self::$order->form_details );
		if ( ! $formDetails || ! property_exists( $formDetails, 'fields' ) ) {
			return array();
		}

		$customer = array();
		foreach ( $formDetails->fields as $detail ) {
			$value = is_array( $detail->value ) ? implode( ', ', $detail->value ) : $detail->value;
			$customer[ $detail->name ] = $value;
		}

		do_action( 'ccb_get_customer_data', $customer );

		return $customer;
	}

	protected static function getSettings() {
		if ( empty( self::$settings ) ) {
			self::$settings = CCBSettingsData::get_calc_single_settings( self::$calculatorId );
		}
		return self::$settings;
	}

	protected static function getGeneralSettings() {
		if ( empty( self::$general_settings ) ) {
			self::$general_settings = get_option( 'ccb_general_settings', CCBSettingsData::general_settings_data() );
		}
		return self::$general_settings;
	}

	protected static function getPaymentSettings() {
		return self::getPaymentSettingsHandler( self::$paymentMethod );
	}

	protected static function getPaymentSettingsHandler( $slug ) {
		$general_settings = self::getPaymentGeneralSettingsBySlug( $slug );
		$settings         = self::getPaymentSettingsBySlug( $slug );

		if ( ! empty( $general_settings ) && ! empty( $general_settings['use_in_all'] ) && ( 'paypal' === $slug || ! empty( $general_settings['enable'] ) ) ) {
			foreach ( $general_settings as $settings_field_key => $settings_field_value ) {
				if ( ! in_array( $settings_field_key, array( 'enable', 'use_in_all' ), true ) ) {
					$settings[ $settings_field_key ] = $settings_field_value;
				}
			}
		}

		return ! empty( $settings ) ? (array) $settings : array();
	}

	protected static function getPaymentGeneralSettingsBySlug( $slug ) {
		$general_settings = self::getGeneralSettings();
		if ( 'paypal' === $slug && isset( $general_settings['payment_gateway'] ) ) {
			return $general_settings['payment_gateway']['paypal'];
		}

		if ( 'cash_payment' === $slug && isset( $general_settings['payment_gateway'] ) ) {
			return $general_settings['payment_gateway']['cash_payment'];
		}

		if ( 'stripe' === $slug && isset( $general_settings['payment_gateway'] ) ) {
			$stripe_settings               = $general_settings['payment_gateway']['cards']['card_payments']['stripe'];
			$stripe_settings['use_in_all'] = $general_settings['payment_gateway']['cards']['use_in_all'];

			return $stripe_settings;
		}

		if ( 'twoCheckout' === $slug && isset( $general_settings['payment_gateway'] ) ) {
			$twoCheckout_settings               = $general_settings['payment_gateway']['cards']['card_payments']['twoCheckout'];
			$twoCheckout_settings['use_in_all'] = $general_settings['payment_gateway']['cards']['use_in_all'];

			return $twoCheckout_settings;
		}

		if ( 'razorpay' === $slug && isset( $general_settings['payment_gateway'] ) ) {
			$razorpay_settings               = $general_settings['payment_gateway']['cards']['card_payments']['razorpay'];
			$razorpay_settings['use_in_all'] = $general_settings['payment_gateway']['cards']['use_in_all'];

			return $razorpay_settings;
		}

		return $general_settings[ $slug ] ?? array();
	}

	protected static function getPaymentSettingsBySlug( $slug ) {
		$settings       = self::getSettings();
		$inner_settings = array();

		if ( 'paypal' === $slug && isset( $settings['payment_gateway'] ) ) {
			$inner_settings = $settings['payment_gateway']['paypal'];
		}

		if ( 'cash_payment' === $slug && isset( $settings['payment_gateway'] ) ) {
			$inner_settings = $settings['payment_gateway']['cash_payment'];
		}

		if ( 'stripe' === $slug && isset( $settings['payment_gateway'] ) ) {
			$inner_settings = $settings['payment_gateway']['cards']['card_payments']['stripe'];
		}

		if ( 'twoCheckout' === $slug && isset( $settings['payment_gateway'] ) ) {
			$inner_settings = $settings['payment_gateway']['cards']['card_payments']['twoCheckout'];
		}

		if ( 'razorpay' === $slug && isset( $settings['payment_gateway'] ) ) {
			$inner_settings = $settings['payment_gateway']['cards']['card_payments']['razorpay'];
		}

		if ( ! empty( $inner_settings ) ) {
			$inner_settings['formulas'] = $settings['payment_gateway']['formulas'];
			return $inner_settings;
		}

		return $settings[ $slug ] ?? array();
	}

	protected static function getTotal() {
		$total = 0;
		if ( count( self::$params['calcTotals'] ) > 0 ) {
			if ( ! empty( self::$paymentSettings['formulas'] ) ) {
				foreach ( self::$paymentSettings['formulas'] as $formula ) {
					foreach ( self::$params['calcTotals'] as $value ) {
						if ( isset( $formula['alias'] ) && isset( $value['alias'] ) && $value['alias'] === $formula['alias'] ) {
							if ( isset( $value['total'] ) ) {
								$total += floatval( $value['total'] );
							} elseif ( isset( $value['value'] ) ) {
								$total += floatval( $value['value'] );
							}
						} elseif ( 1 === count( self::$paymentSettings['formulas'] ) && ! isset( $formula['alias'] ) ) {
							$total += floatval( $value['total'] );
						}
					}
				}
			}
		}

		if ( 0 === $total && count( self::$params['calcTotals'] ) > 0 ) {
			$total = isset( self::$params['calcTotals'][0]['total'] ) ? self::$params['calcTotals'][0]['total'] : '';
		}

		return $total;
	}

	protected static function updateOrder() {
		OrdersModel::update_order(
			array(
				'payment_method' => self::$paymentMethod,
			),
			self::$params['order_id']
		);
	}

	protected static function createPayment() {
		$paymentData = array(
			'type'     => self::$paymentMethod,
			'total'    => self::$total,
			'currency' => self::$settings['currency']['currency'],
		);
		PaymentModel::create_new_payment( $paymentData, self::$params['order_id'] );
	}

	protected static function updatePayment() {
		PaymentModel::update(
			array(
				'type'       => self::$paymentMethod,
				'updated_at' => wp_date( 'Y-m-d H:i:s' ),
			),
			array(
				'order_id' => self::$params['order_id'],
			)
		);

		return PaymentModel::get( 'order_id', self::$params['order_id'] );
	}

	protected static function sendEmail( $custom_params = array() ) {
		if ( ! empty( self::$params['sendFields'] ) || ! empty( $custom_params['sendFields'] ) ) {
			if ( empty( self::$calculatorId ) && ! empty( $custom_params ) ) {
				self::$calculatorId = $custom_params['calcId'];
			}

			if ( empty( self::$settings ) && ! empty( $custom_params ) ) {
				self::$settings = self::getSettings();
			}

			if ( empty( self::$params ) && ! empty( $custom_params ) ) {
				self::$params = $custom_params;
			}

			$subject       = '';
			$user_email    = '';
			$custom_emails = array();
			$client_email  = self::$params['clientEmail'];

			if ( isset( self::$settings['formFields'] ) ) {
				if ( isset( self::$settings['formFields']['emailSubject'] ) ) {
					$subject = self::$settings['formFields']['emailSubject'];
				}

				if ( isset( self::$settings['formFields']['adminEmailAddress'] ) ) {
					$user_email = self::$settings['formFields']['adminEmailAddress'];
				}

				if ( isset( self::$settings['formFields']['customEmailAddresses'] ) ) {
					$custom_emails = self::$settings['formFields']['customEmailAddresses'];
				}
			}

			$subject = apply_filters( 'cbb_email_subject', $subject, self::$params['calcId'] );

			$general_settings = CCBSettingsData::get_calc_global_settings();
			$fields           = array_map(
				function ( $field ) {
					$allowed_fields = array(
						'checkbox_field',
						'toggle_field',
						'checkbox_with_img_field',
					);
					foreach ( $allowed_fields as $allowed ) {
						if ( ! isset( $value['extra'] ) && str_contains( $field['alias'], $allowed ) ) {
							$field['has_options'] = true;
						}
					}
					return $field;
				},
				self::$params['descriptions']
			);

			$fields = array_filter(
				$fields,
				function ( $field ) {
					return ! str_contains( $field['alias'], 'group' );
				}
			);

			$attachments = array();

			/** upload files, get  $file_urls */
			$file_urls = CCBContactForm::add_files( self::$params );

			if ( count( $file_urls ) > 0 ) {
				foreach ( $file_urls as $file_item ) {
					$attachments = array_merge( $attachments, array_column( $file_item, 'file' ) );
				}
			}

			$attachments = apply_filters( 'ccb_email_attachment', $attachments, self::$params );

			$discount_data = array();
			if ( ! empty( self::$params['order_id'] ) ) {
				$discount_data = Orders::get_order_discounts( self::$params['order_id'] );
			}

			$args = array(
				'fields'         => $fields,
				'send_fields'    => self::$params['sendFields'],
				'totals'         => $discount_data['totals'] ?? self::$params['calcTotalsConverted'],
				'other_totals'   => isset( self::$params['otherTotals'] ) ? self::$params['otherTotals'] : array(),
				'email_settings' => $general_settings['email_templates'],
				'files'          => $file_urls,
				'show_unit'      => self::$params['showUnit'] ?? '',
				'calc_id'        => self::$params['calcId'],
				'order_id'       => self::$params['order_id'],
				'promocodes'     => $discount_data['promocodes'] ?? array(),
			);

			CCBContactForm::sendEmail(
				array(
					'args'          => $args,
					'calcId'        => self::$params['calcId'],
					'client_email'  => $client_email,
					'subject'       => $subject,
					'attachments'   => $attachments,
					'user_email'    => $user_email,
					'custom_emails' => $custom_emails,
				)
			);
		}
	}
}

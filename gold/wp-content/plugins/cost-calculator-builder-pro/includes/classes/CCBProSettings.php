<?php

namespace cBuilder\Classes;

class CCBProSettings {
	public static function init() {
		// admin
		add_action( 'render-date-picker', array( self::class, 'render_date_picker' ) );
		add_action( 'render-time-picker', array( self::class, 'render_time_picker' ) );
		add_action( 'render-file-upload', array( self::class, 'render_file_upload' ) );
		add_action( 'render-multi-range', array( self::class, 'render_multi_range' ) );
		add_action( 'render-form-elements', array( self::class, 'render_validated_form' ) );
		add_action( 'render-drop-down-with-img', array( self::class, 'render_drop_down_with_img' ) );
		add_action( 'render-radio-with-img', array( self::class, 'render_radio_with_img' ) );
		add_action( 'render-checkbox-with-img', array( self::class, 'render_checkbox_with_img' ) );
		add_action( 'render-repeater-field', array( self::class, 'render_repeater_field' ) );
		add_action( 'render-group-field', array( self::class, 'render_group_field' ) );
		add_action( 'render-geolocation', array( self::class, 'render_geolocation' ) );
		add_action( 'render-page-break-field', array( self::class, 'render_page_break_field' ) );

		// admin settings
		add_action( 'render-condition', array( self::class, 'render_condition' ) );
		add_action( 'render-discounts', array( self::class, 'render_discounts' ) );

		add_action( 'render-general-geolocation', array( self::class, 'render_general_geolocation' ) );
		add_action( 'render-general-invoice', array( self::class, 'render_general_invoice' ) );
		add_action( 'render-general-share-quote-form', array( self::class, 'render_general_share_quote_form' ) );
		add_action( 'render-general-email', array( self::class, 'render_general_email' ) );
		add_action( 'render-general-email-template', array( self::class, 'render_general_email_template' ) );
		add_action( 'render-general-captcha', array( self::class, 'render_general_captcha' ) );
		add_action( 'render-general-payment-gateway', array( self::class, 'render_general_payment_gateway' ) );

		add_action( 'render-notice', array( self::class, 'render_notice' ) );
		add_action( 'render-recaptcha', array( self::class, 'render_recaptcha' ) );
		add_action( 'render-default-form', array( self::class, 'render_default_form' ) );

		add_action( 'render-sticky-calculator', array( self::class, 'render_sticky_calculator' ) );
		add_action( 'render-send-form', array( self::class, 'render_send_form' ) );
		add_action( 'render-form-manager', array( self::class, 'render_form_manager' ) );
		add_action( 'render-woo-checkout', array( self::class, 'render_woo_checkout' ) );
		add_action( 'render-woo-products', array( self::class, 'render_woo_products' ) );
		add_action( 'render-webhooks', array( self::class, 'render_webhooks' ) );
		add_action( 'render-backup-settings', array( self::class, 'render_backup_settings' ) );
		add_action( 'render-ai', array( self::class, 'render_ai_settings' ) );
		add_action( 'render-thank-you-page', array( self::class, 'render_thank_you_page' ) );
		add_action( 'render-payment-gateway', array( self::class, 'render_payment_gateway' ) );

		add_filter(
			'calc_render_conditions',
			function ( $arr, $calc_id ) {
				return get_post_meta( $calc_id, 'stm-conditions', true );
			},
			10,
			2
		);
	}

	public static function render_general_geolocation() {
		echo CCBProTemplate::load( 'admin/general-settings/geolocation' ); //phpcs:ignore
	}

	public static function render_general_invoice() {
		echo CCBProTemplate::load( 'admin/general-settings/invoice' ); //phpcs:ignore
	}

	public static function render_general_share_quote_form() {
		echo CCBProTemplate::load( 'admin/general-settings/share-quote-form' ); //phpcs:ignore
	}

	public static function render_general_email() {
		echo CCBProTemplate::load( 'admin/general-settings/email' ); //phpcs:ignore
	}

	public static function render_general_email_template() {
		echo CCBProTemplate::load( 'admin/general-settings/email-template' ); //phpcs:ignore
	}

	public static function render_general_captcha() {
		echo CCBProTemplate::load( 'admin/general-settings/captcha' ); //phpcs:ignore
	}

	public static function render_general_payment_gateway() {
		echo CCBProTemplate::load( 'admin/general-settings/payment-gateway' ); //phpcs:ignore
	}

	public static function render_condition() {
		echo CCBProTemplate::load( 'admin/condition' ); //phpcs:ignore
	}

	public static function render_discounts() {
		echo CCBProTemplate::load( 'admin/discounts' ); //phpcs:ignore
	}

	public static function render_date_picker() {
		echo CCBProTemplate::load( 'admin/fields/date-picker-field' ); //phpcs:ignore
	}

	public static function render_time_picker() {
		echo CCBProTemplate::load( 'admin/fields/time-picker-field' ); //phpcs:ignore
	}

	public static function render_multi_range() {
		echo CCBProTemplate::load( 'admin/fields/multi-range-field' ); //phpcs:ignore
	}

	public static function render_validated_form() {
		echo CCBProTemplate::load( 'admin/fields/validated-form-field' ); //phpcs:ignore
	}

	public static function render_file_upload() {
		echo CCBProTemplate::load( 'admin/fields/file-upload-field' ); //phpcs:ignore
	}

	public static function render_drop_down_with_img() {
		echo CCBProTemplate::load( 'admin/fields/drop-down-with-image-field' ); //phpcs:ignore
	}

	public static function render_radio_with_img() {
		echo CCBProTemplate::load( 'admin/fields/radio-with-image-field' ); //phpcs:ignore
	}

	public static function render_checkbox_with_img() {
		echo CCBProTemplate::load( 'admin/fields/checkbox-with-image-field' ); //phpcs:ignore
	}

	public static function render_repeater_field() {
		echo CCBProTemplate::load( 'admin/fields/repeater-field' ); //phpcs:ignore
	}

	public static function render_group_field() {
		echo CCBProTemplate::load( 'admin/fields/group-field' ); //phpcs:ignore
	}

	public static function render_geolocation() {
		echo CCBProTemplate::load( 'admin/fields/geolocation-field' ); //phpcs:ignore
	}

	public static function render_page_break_field() {
		echo CCBProTemplate::load( 'admin/fields/page-break-field' ); //phpcs:ignore
	}

	public static function render_notice() {
		echo CCBProTemplate::load( 'admin/settings/notice' ); //phpcs:ignore
	}

	public static function render_recaptcha() {
		echo CCBProTemplate::load( 'admin/settings/recaptcha' ); //phpcs:ignore
	}

	public static function render_default_form() {
		echo CCBProTemplate::load( 'admin/settings/default-form' ); //phpcs:ignore
	}

	public static function render_send_form() {
		echo CCBProTemplate::load( 'admin/settings/send-form' ); //phpcs:ignore
	}

	public static function render_form_manager() {
		echo CCBProTemplate::load( 'admin/settings/form-manager' ); //phpcs:ignore
	}

	public static function render_sticky_calculator() {
		echo CCBProTemplate::load( 'admin/settings/sticky-calculator' ); //phpcs:ignore
	}

	public static function render_woo_products() {
		echo CCBProTemplate::load( 'admin/settings/woo-products' ); //phpcs:ignore
	}

	public static function render_woo_checkout() {
		echo CCBProTemplate::load( 'admin/settings/woo-checkout' ); //phpcs:ignore
	}

	public static function render_webhooks() {
		echo CCBProTemplate::load( 'admin/settings/webhooks' ); //phpcs:ignore
	}

	public static function render_backup_settings() {
		echo CCBProTemplate::load( 'admin/general-settings/backup-settings' ); //phpcs:ignore
	}

	public static function render_ai_settings() {
		echo CCBProTemplate::load( 'admin/general-settings/ai' ); //phpcs:ignore
	}

	public static function render_thank_you_page() {
		echo CCBProTemplate::load( 'admin/settings/thank-you-page' ); //phpcs:ignore
	}

	public static function render_payment_gateway() {
		echo CCBProTemplate::load( 'admin/settings/payment-gateway' ); //phpcs:ignore
	}

	public static function get_payments() {
		return array(
			'stripe'       => array(
				'label'    => __( 'Stripe', 'cost-calculator-builder-pro' ),
				'slug'     => 'stripe',
				'value'    => 'stripe',
				'image'    => CALC_URL . '/frontend/dist/img/payments/card_payment.webp',
				'width'    => '115px',
				'has_body' => true,
			),
			'razorpay'     => array(
				'label'    => __( 'Razorpay', 'cost-calculator-builder-pro' ),
				'slug'     => 'razorpay',
				'value'    => 'razorpay',
				'image'    => CALC_URL . '/frontend/dist/img/payments/card_payment.webp',
				'width'    => '112px',
				'has_body' => false,
			),
			'paypal'       => array(
				'label'       => __( 'Paypal', 'cost-calculator-builder-pro' ),
				'slug'        => 'paypal',
				'value'       => 'paypal',
				'image'       => CALC_URL . '/frontend/dist/img/payments/paypal.webp',
				'description' => __( 'You will be redirected to PayPal website', 'cost-calculator-builder-pro' ),
				'width'       => '82px',
				'has_body'    => true,
			),
			'woo_checkout' => array(
				'label'    => __( 'Add to cart', 'cost-calculator-builder-pro' ),
				'slug'     => 'woo_checkout',
				'value'    => 'woocommerce_checkout',
				'image'    => CALC_URL . '/frontend/dist/img/payments/woocommerce.webp',
				'width'    => '44px',
				'has_body' => false,
			),
			'cash_payment' => array(
				'label'       => __( 'Cash payment', 'cost-calculator-builder-pro' ),
				'slug'        => 'cash_payment',
				'value'       => 'cash_payment',
				'image'       => CALC_URL . '/frontend/dist/img/payments/cash_payment.webp',
				'width'       => '32px',
				'description' => '',
				'has_body'    => true,
			),
		);
	}
}

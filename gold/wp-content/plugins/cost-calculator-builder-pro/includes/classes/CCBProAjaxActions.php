<?php

namespace cBuilder\Classes;

use cBuilder\Classes\Payments\CCBPayPal;
use cBuilder\Classes\Payments\CCBRazorPay;
use cBuilder\Classes\Payments\CCBStripe;
use cBuilder\Classes\CCBInvoice;

class CCBProAjaxActions {

	/**
	 * @param string   $tag The name of the action to which the $function_to_add is hooked.
	 * @param callable $function_to_add The name of the function you wish to be called.
	 * @param boolean  $nonpriv Optional. Boolean argument for adding wp_ajax_nopriv_action. Default false.
	 * @param int      $priority Optional. Used to specify the order in which the functions
	 *                                       associated with a particular action are executed. Default 10.
	 *                                       Lower numbers correspond with earlier execution,
	 *                                       and functions with the same priority are executed
	 *                                       in the order in which they were added to the action.
	 * @param int      $accepted_args Optional. The number of arguments the function accepts. Default 1.
	 * @return true Will always return true.
	 */

	public static function addAction( $tag, $function_to_add, $nonpriv = false, $priority = 10, $accepted_args = 1 ) {
		add_action( 'wp_ajax_' . $tag, $function_to_add, $priority = 10, $accepted_args = 1 );
		if ( $nonpriv ) {
			add_action( 'wp_ajax_nopriv_' . $tag, $function_to_add );
		}
		return true;
	}

	public static function init() {
		self::addAction( 'ccb_generate_formula', array( CCBAiHelper::class, 'generate_formula' ), true );

		// payment methods
		self::addAction( 'ccb_payment', array( CCBPayments::class, 'renderPayment' ), true );
		self::addAction( 'ccb_razorpay_payment_received', array( CCBRazorPay::class, 'paymentReceived' ), true );

		// WooCommerce Checkout
		self::addAction( 'calc_woo_redirect', array( CCBWooCheckout::class, 'init' ), true );

		// contact form
		self::addAction( 'calc_contact_form', array( CCBContactForm::class, 'render' ), true );

		/** Cost Calculator PDF Invoice  */
		self::addAction( 'ccb_get_pdf_data', array( CCBInvoice::class, 'ccb_get_pdf_data' ), true );
		self::addAction( 'ccb_send_invoice', array( CCBInvoice::class, 'send_pdf_front' ), true );
		self::addAction( 'ccb_send_pdf', array( CCBInvoice::class, 'send_pdf' ), true );

		/** Cost Calculator Demo Webhooks */
		self::addAction( 'ccb_send_demo_webhook', array( CCBWebhooks::class, 'send_demo_webhook' ), true );

		/** Cost Calculator Wp Hooks */
		self::addAction( 'ccb_confirmation_pdf_button_action', array( CCBWpHooks::class, 'return_demo_response' ), true );
		self::addAction( 'ccb_confirmation_back_button_action', array( CCBWpHooks::class, 'return_demo_response' ), true );
		self::addAction( 'ccb_confirmation_custom_button_action', array( CCBWpHooks::class, 'return_demo_response' ), true );

		/** Woocommerce Integration hooks **/
		add_action( 'woocommerce_new_order_item', array( CCBWooCheckout::class, 'calc_add_wc_order' ), 99, 3 );
		add_action( 'woocommerce_checkout_create_order_line_item', array( CCBWooCheckout::class, 'calc_add_item_meta' ), 99, 4 );
		add_filter( 'woocommerce_get_item_data', array( CCBWooCheckout::class, 'calc_get_item_data' ), 99, 2 );
		add_action( 'woocommerce_check_cart_items', array( CCBWooCheckout::class, 'calc_check_cart_items' ), 99 );
		add_filter( 'woocommerce_order_item_meta_end', array( CCBWooCheckout::class, 'calc_order_item_meta' ), 99, 2 );
		add_action( 'woocommerce_before_calculate_totals', array( CCBWooCheckout::class, 'calc_total' ), 99, 1 );
		add_action( 'woocommerce_after_order_itemmeta', array( CCBWooCheckout::class, 'calc_order_item_meta' ), 99, 3 );
		add_action( 'woocommerce_cart_item_removed', array( CCBWooCheckout::class, 'calc_remove_cart_item' ), 99, 2 );
		add_filter( 'woocommerce_order_again_cart_item_data', array( CCBWooCheckout::class, 'calc_order_again' ), 99, 3 );
	}
}

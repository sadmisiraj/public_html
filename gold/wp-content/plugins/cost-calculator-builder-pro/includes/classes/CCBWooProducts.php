<?php

namespace cBuilder\Classes;

class CCBWooProducts {

	/**
	* CCBWooProducts Init
	*/
	public static function init() {
		$woocommerce_calcs = get_option( 'stm_ccb_woocommerce_calcs', array() );

		if ( ! empty( $woocommerce_calcs ) && is_array( $woocommerce_calcs ) ) {
			foreach ( $woocommerce_calcs as $calc_id ) {
				$ccb_settings = CCBSettingsData::get_calc_single_settings( $calc_id );
				$settings     = $ccb_settings['woo_products'];
				self::show_calculator( $calc_id, $settings );

				if ( empty( $settings['hide_woo_cart'] ) ) {
					self::remove_add_to_cart_button( $settings, $calc_id );
				}
			}
		}
	}

	/**
	* Show Calculator on WooCommerce Product page
	*
	* @param $calc_id
	* @param $settings
	*/
	public static function show_calculator( $calc_id, $settings ) {
		add_action(
			(string) $settings['hook_to_show'],
			function () use ( $calc_id, $settings ) {
				if ( self::is_category_included_or_is_product_included( $settings ) && ! self::product_is_in_out_of_stock() ) {
					echo do_shortcode( "[stm-calc id='" . esc_attr( $calc_id ) . "']" );
				}
			},
			5
		);

		add_action(
			'woocommerce_checkout_create_order',
			function ( $order ) {
				foreach ( $order->get_items() as $item ) {
					$new_quantity = $item->get_quantity();

					foreach ( $item->get_meta_data() as $meta_data ) {
						if ( 'ccb_calculator' === $meta_data->key ) {
							if ( ! array_key_exists( 'ccb_woo_meta_link_quantity_data', $meta_data->value ) ) {
								continue;
							}
							if ( false === $meta_data->value['ccb_woo_meta_link_quantity_data']['is_set'] ) {
								continue;
							}
							$new_quantity = $meta_data->value['ccb_woo_meta_link_quantity_data']['total'];
						}
					}

					$item->set_quantity( $new_quantity );
				}
			},
			1
		);
	}

	/**
	* Hide WooCommerce Add to Cart Button
	*
	* @param $settings
	*/
	public static function remove_add_to_cart_button( $settings, $calc_id ) {
		add_action(
			'woocommerce_simple_add_to_cart',
			function () use ( $settings ) {
				if ( self::is_category_included_or_is_product_included( $settings ) && ! $settings['hide_woo_cart'] ) {
					remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
				}
			},
			1
		);

		add_filter(
			'woocommerce_loop_add_to_cart_link',
			function ( $product ) use ( $settings ) {
				if ( self::is_category_included_or_is_product_included( $settings ) && ! $settings['hide_woo_cart'] ) {
					return '';
				}
				return $product;
			},
			10
		);
	}

	/**
	* Check if Current Product Category Included for Calculator
	*
	* @param $settings
	* @return bool
	*/
	public static function is_category_included_or_is_product_included( $settings ) {
		if ( ! empty( $settings['by_category'] ) ) {
			if ( empty( $settings['category_ids'] ) ) {
				return false;
			}
			return has_term( $settings['category_ids'], 'product_cat', get_the_ID() );
		} elseif ( ! empty( $settings['by_product'] ) ) {
			return in_array( get_the_ID(), $settings['product_ids'], true );
		}

		return false;
	}

	public static function product_is_in_out_of_stock() {
		$status = get_post_meta( get_the_ID(), '_stock_status', true );
		return 'outofstock' === $status;
	}

	public static function get_current_product_stock_data() {
		global $product;
		return array(
			'stock_quantity' => $product->get_stock_quantity(),
			'stock_status'   => $product->get_stock_status(),
			'price'          => $product->get_price(),
		);
	}
}

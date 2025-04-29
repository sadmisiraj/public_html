<?php

namespace cBuilder\Classes;

use cBuilder\Classes\Database\Discounts;
use function Breakdance\Util\Timing\start;

class CCBCalculator {
	private static $calc_data;
	private static $calc_global_data;

	private static $payment_totals = array();

	private static $discounts = array();

	private static $default_total = null;

	public static function validate_totals( $data ) {
		$calc_id        = $data['id'];
		$payment_method = $data['paymentMethod'] ?? '';
		$original_pm    = $data['originalPaymentMethod'] ?? '';
		$order_details  = $data['orderDetails'] ?? array();
		$hidden_details = $data['hiddenOrderDetails'] ?? array();
		$promocodes     = $data['promocodes'] ?? array();
		$order_details  = array_merge( $order_details, $hidden_details );

		self::set_calc_data( $calc_id );
		self::set_payment_totals( $payment_method, $calc_id, $order_details, $original_pm );

		$totals_data  = self::get_calc_totals( $calc_id, $order_details );
		$total_fields = self::get_calculated_totals( $totals_data, $order_details );
		$total_fields = self::parse_discount_totals( $calc_id, $total_fields, $promocodes );
		$total_fields = self::total_in_totals_after_discounts_applied( $total_fields, $promocodes );

		$total_fields = self::parse_conditions( $calc_id, $order_details, $total_fields, $promocodes );
		$totals_data  = self::separate_totals( $total_fields );

		$totals_data['totals']       = self::set_measuring_unit( $totals_data['totals'] );
		$totals_data['other_totals'] = self::set_measuring_unit( $totals_data['other_totals'] );

		$data['calcName']  = self::get_calc_name( $calc_id );
		$data['total']     = self::get_payment_method_total( $totals_data['totals'] );
		$data['converted'] = self::currency_convertor( $data['total'] );

		$final_totals = array();
		foreach ( $totals_data['totals'] as $total ) {
			if ( empty( $total['hidden'] ) || ! empty( $total['calculateHidden'] ) ) {
				$final_totals[] = $total;
			}
		}

		$final_other_totals = array();
		foreach ( $totals_data['other_totals'] as $total ) {
			if ( empty( $total['hidden'] ) || ! empty( $total['calculateHidden'] ) ) {
				$final_other_totals[] = $total;
			}
		}

		if ( empty( self::$calc_data['general']['hide_empty_for_orders_pdf_emails'] ) ) {
			$filtered_final_totals       = array();
			$filtered_final_other_totals = array();

			foreach ( $final_totals as $value ) {
				if ( ! empty( $value['total'] ) ) {
					$filtered_final_totals[] = $value;
				}
			}

			foreach ( $final_other_totals as $value ) {
				if ( ! empty( $value['total'] ) ) {
					$filtered_final_other_totals[] = $value;
				}
			}

			$final_totals       = $filtered_final_totals;
			$final_other_totals = $filtered_final_other_totals;
		}

		$data['totals']      = $final_totals;
		$data['otherTotals'] = $final_other_totals;

		return $data;
	}

	private static function get_payment_method_total( $total_fields ) {
		$payment_totals = self::$payment_totals;

		if ( is_array( $payment_totals ) && 0 === count( $payment_totals ) ) {
			return 0;
		}

		$total_value   = 0;
		$mapped_totals = array();

		foreach ( $total_fields as $total_field ) {
			$mapped_totals[ $total_field['alias'] ] = $total_field;
		}

		foreach ( $payment_totals as $total ) {
			if ( ! empty( $total['alias'] ) && isset( $mapped_totals[ $total['alias'] ] ) ) {
				$current      = $mapped_totals[ $total['alias'] ];
				$total_value += $current['total'];
			}
		}

		return $total_value;
	}

	private static function get_calc_totals( $calc_id, $order_details ) {
		$data      = get_post_meta( $calc_id, 'stm-fields', true ) ?? array();
		$totals    = array();
		$repeaters = array();
		$fields    = array();

		foreach ( $data as $item ) {
			$fields[] = $item;

			if ( isset( $item['groupElements'] ) && ( str_contains( $item['alias'], 'group_field' ) || str_contains( $item['alias'], 'page' ) ) ) {
				$fields = array_merge( $fields, $item['groupElements'] );

				if ( str_contains( $item['alias'], 'page' ) ) {
					foreach ( $item['groupElements'] as $innerPage ) {
						if ( isset( $innerPage['groupElements'] ) ) {
							$fields = array_merge( $fields, $innerPage['groupElements'] );
						}
					}
				}
			}
		}

		foreach ( $fields as $field ) {
			if ( ! empty( $field['alias'] ) && ( str_contains( $field['alias'], 'total_field_id' ) || str_contains( $field['alias'], 'repeater_field_id' ) ) ) {
				$formula = '';
				if ( str_contains( $field['alias'], 'total_field_id' ) ) {
					$formula = empty( $field['formulaView'] ) ? $field['costCalcFormula'] : $field['legacyFormula'];
				} else {
					if ( ! empty( $field['sumAllAvailable'] ) ) {
						if ( count( $field['groupElements'] ) > 0 ) {
							$formula .= '( ';
							foreach ( $field['groupElements'] as $idx => $f ) {
								$formula .= $f['alias'];
								if ( ( count( $field['groupElements'] ) - 1 ) !== $idx ) {
									$formula .= ' + ';
								}
							}
							$formula .= ' )';
						} else {
							$formula = '0';
						}
					} else {
						$formula = $field['costCalcFormula'] ?? '0';
					}
				}

				$new_field = array(
					'id'      => $field['_id'],
					'label'   => $field['label'],
					'alias'   => $field['alias'],
					'formula' => $formula,
				);

				if ( isset( $field['fieldCurrency'] ) ) {
					$new_field['fieldCurrency']         = $field['fieldCurrency'];
					$new_field['fieldCurrencySettings'] = $field['fieldCurrencySettings'];
				}

				if ( isset( $field['calculateHidden'] ) ) {
					$new_field['calculateHidden'] = $field['calculateHidden'];
				}

				if ( isset( $field['hidden'] ) ) {
					$new_field['hidden'] = $field['hidden'];
				}

				if ( ! empty( $field['advancedJsCalculation'] ) ) {
					$new_field['advancedJsCalculation'] = $field['advancedJsCalculation'];
				}

				$new_field['hasDiscount'] = '';

				if ( str_contains( $new_field['alias'], 'repeater_field_id' ) ) {
					$repeaters[] = $new_field;
				} else {
					$totals[] = $new_field;
				}
			}
		}

		if ( empty( $totals ) ) {
			$default_total = self::generate_default_formula( $fields, $order_details );
			$totals[]      = $default_total;
		}

		usort(
			$totals,
			function ( $item1, $item2 ) {
				return $item1['id'] <=> $item2['id'];
			}
		);

		return array_merge( $repeaters, $totals );
	}

	private static function extractNumber( $input ) {
		preg_match( '/\d+(\.\d+ )?/', $input, $matches );
		return $matches[0] ?? '';
	}

	private static function get_calculated_totals( $totals, $order_details ) {
		foreach ( $totals as $idx => $total ) {
			if ( ! empty( $total['formula'] ) ) {
				if ( str_contains( $total['alias'], 'repeater_field_id' ) ) {
					$groupElements = array();
					$length        = 0;
					foreach ( $order_details as $detail ) {
						if ( $detail['alias'] === $total['alias'] && ! empty( $detail['groupElements'] ) ) {
							$groupElements = $detail['groupElements'];
							$length        = $detail['length'] ?? $length;
						}
					}

					$formula = '';
					for ( $i = 0; $i < $length; $i++ ) {
						$inner_formula = '( ' . $total['formula'];

						foreach ( $groupElements as $groupElement ) {
							if ( isset( $groupElement['idx'] ) && intval( $groupElement['idx'] ) === $i ) {
								$inner_formula = preg_replace( '/\b' . preg_quote( $groupElement['alias'], '/' ) . '\b/', self::extractNumber( $groupElement['value'] ), $inner_formula );
							}
						}

						$formula .= $inner_formula . ' )';
						if ( ( intval( $length ) - 1 ) !== $i ) {
							$formula .= ' + ';
						}
					}

					$total['formula'] = $formula;
				} else {
					foreach ( $order_details as $detail ) {
						$alias = $detail['alias'] ?? '';
						if ( str_contains( $alias, 'repeater' ) ) {
							continue;
						}
						$value            = $detail['originalValue'] ?? 0;
						$total['formula'] = preg_replace( '/\b' . preg_quote( $alias, '/' ) . '\b/', $value, $total['formula'] );
					}
				}
			}

			if ( str_contains( $total['formula'], 'total_field_id' ) || str_contains( $total['formula'], 'repeater_field_id' ) ) {
				$total['before_total_parse'] = $total['formula'];
				foreach ( $totals as $inner_total ) {
					if ( str_contains( $total['formula'], $inner_total['alias'] ) ) {
						$total['formula'] = preg_replace( '/\b' . preg_quote( $inner_total['alias'], '/' ) . '\b/', $inner_total['total'] ?? 0, $total['formula'] );
					}
				}
			}

			$total['advancedJsCalculation'] = isset( $total['advancedJsCalculation'] ) ? $total['advancedJsCalculation'] : false;
			$total['formula']                 = preg_replace( '/\b\w+_field_id_\d+\b/', '0', $total['formula'] );
			$total['total']                   = self::evaluateFormula( $total['formula'], $total['advancedJsCalculation'] );
			$total['converted']               = self::currency_convertor( $total['total'] );
			$total['summary']                 = $total['total'];
			$total['summary_converted']       = $total['converted'];
			$total['value']                   = $total['converted'];

			$totals[ $idx ] = $total;
		}

		return $totals;
	}

	private static function evaluateFormula( $formula, $make_request = false ) {
		// phpcs:disable
		$pattern = '/\b(if|else|else\s*if|Math(?:\.\w+))\b|\b\w+_field_id_\w*\b|\b(?!if\b|else\b|else\s*if\b|Math(?:\.\w+)?)(?!\d+(\.\d+)?)(\w+)\b/';

		$formula = preg_replace_callback(
			$pattern,
			function ( $matches ) {
				if ( ! in_array( $matches[0], array( 'if', 'else', 'else if', 'Math.floor', 'Math.sqrt', 'Math.min', 'Math.max', 'Math.pow', 'Math.ceil', 'Math.sqrt', 'Math.abs', 'Math.round' ), true ) ) {
					return '0';
				}
				return $matches[0];
			},
			$formula
		);

		if ( $make_request ) {
			return self::make_request( $formula );
		} else {
			$result = self::js_to_php( $formula );
			return empty( $result ) ? 0 : $result;
		}
	}

	private static function make_request( $formula ) {
		$url  = 'https://ccb-emailmanager.stylemixthemes.com/api/v1/calculate';
		$data = array(
			'formula' => $formula,
		);

		$jsonData = json_encode( $data ); // phpcs:ignore

		$ch = curl_init( $url ); // phpcs:ignore

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); // phpcs:ignore
		curl_setopt( $ch, CURLOPT_POST, true ); // phpcs:ignore
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $jsonData ); // phpcs:ignore
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json', 'Content-Length: ' . strlen( $jsonData ) ) ); // phpcs:ignore

		$response = curl_exec( $ch ); // phpcs:ignore

		if ( curl_errno( $ch ) ) { // phpcs:ignore
			$result = '0';
		} else {
			$response = json_decode( $response, true );
			$result   = $response['result'] ?? '0';
		}

		curl_close( $ch ); // phpcs:ignore

		return $result;
	}

	private static function parse_discount_totals( $calc_id, $total_fields, $promocodes ) {

		if ( empty( self::$discounts ) ) {
			$params = array(
				'calc_id' => $calc_id,
				'all'     => true,
			);

			$discounts       = Discounts::get_all_discounts( $params );
			self::$discounts = $discounts;
		}

		$mapped_totals = array();
		foreach ( $total_fields as $total_field ) {
			$mapped_totals[ $total_field['alias'] ] = $total_field;
		}

		if ( ! empty( self::$discounts ) && count( self::$discounts ) > 0 ) {
			foreach ( self::$discounts as $discount ) {
				if ( ! empty( $discount['conditions'] ) ) {

					$promocode = $discount['promocode'] ?? '';
					if ( ! empty( $discount['is_promo'] ) && ! empty( $promocode ) && ! in_array( $promocode, $promocodes, true ) ) {
						continue;
					}

					foreach ( $discount['conditions'] as $condition ) {
						$field_aliases = explode( ',', $condition['field_alias'] );

						if ( ! empty( $field_aliases ) ) {
							foreach ( $field_aliases as $field_alias ) {
								if ( isset( $mapped_totals[ $field_alias ] ) ) {
									$current = $mapped_totals[ $field_alias ];
									$symbol  = '=' === $condition['condition_symbol'] ? '==' : $condition['condition_symbol'];
									$result  = eval( 'return ' . $current['summary'] . $symbol . $condition['over_price'] . ';' ); //phpcs:ignore
									if ( $result && ! empty( $condition['discount_type'] ) ) {
										$new_total          = $current['summary'];
										$original_total     = $current['summary'];
										$original_converted = $current['summary_converted'];

										if ( 'percent_of_amount' === $condition['discount_type'] ) {
											$val = $new_total * ( $condition['discount_amount'] / 100 );
											$val = $new_total - $val;
										} else {
											$val = $new_total - intval( $condition['discount_amount'] );
										}

										//phpcs:disable
										$current['discount'] = array(
											'discountView'       => $discount['view_type'],
											'discountTitle'      => $discount['title'],
											'discountAmount'     => $condition['discount_amount'],
											'discountType'       => $condition['discount_type'],
											'discountValue'      => self::currency_convertor( $condition['discount_amount'] ),
											'hasDiscount'        => '1',
											'promocode'          => $discount['promocode'] ?? '',
											'isPromo'            => $discount['is_promo'],
											'currency'           => 'percent_of_amount' === $condition['discount_type'] ? '%' : self::get_calc_currency_sign(),
											'original_value'     => $original_total,
											'original_converted' => $original_converted,
										);
										//phpcs:enable

										$new_total              = max( $val, 0 );
										$current['total']       = $new_total;
										$current['value']       = $new_total;
										$current['converted']   = self::currency_convertor( $new_total );
										$current['hasDiscount'] = 1;

										$mapped_totals[ $field_alias ] = $current;
									}
								}
							}
						}
					}
				}
			}
		}

		return array_values( $mapped_totals );
	}

	private static function get_calc_name( $calc_id ) {
		return get_post_meta( $calc_id, 'stm-name', true );
	}

	private static function set_payment_totals( $payment_method, $calc_id, $order_details, $original_pm ) {
		$calc_data        = self::$calc_data;
		$calc_global_data = self::$calc_global_data;

		$payments       = array( 'paypal', 'stripe', 'cash_payment', 'razorpay' );
		$payment_totals = array();

		if ( in_array( $payment_method, $payments, true ) ) {
			$payment_totals = $calc_data['payment_gateway']['formulas'] ?? array();

			if ( ! empty( $calc_global_data['payment_gateway']['formulas'] ) ) {
				if ( in_array( $payment_method, array( 'cash_payment', 'paypal' ), true ) && ! empty( $calc_global_data['payment_gateway'][ $payment_method ]['use_in_all'] ) ) {
					$payment_totals = $calc_global_data['payment_gateway']['formulas'];
				}

				if ( in_array( $payment_method, array( 'stripe', 'razorpay' ), true ) && ! empty( $calc_global_data['payment_gateway']['cards']['use_in_all'] ) && ! empty( $calc_global_data['payment_gateway']['cards'][ $payment_method ]['use_in_all'] ) ) {
					$payment_totals = $calc_global_data['payment_gateway']['formulas'];
				}
			}
		}

		if ( 'no_payments' === $payment_method ) {
			if ( ! empty( $original_pm ) ) {
				$payment_totals = $calc_data['woo_checkout']['formulas'] ?? array();
			} else {
				$payment_totals = $calc_data['formFields']['formulas'] ?? array();
			}
		}

		$has_alias = true;

		foreach ( $payment_totals as $total ) {
			if ( $has_alias && empty( $total['alias'] ) ) {
				$has_alias      = false;
				$payment_totals = array();
			}
		}

		if ( ! $has_alias ) {
			$fields           = get_post_meta( $calc_id, 'stm-fields', true ) ?? array();
			$payment_totals[] = self::generate_default_formula( $fields, $order_details );
		}

		self::$payment_totals = $payment_totals;
	}

	private static function currency_convertor( $total ) {
		$calc_data        = self::$calc_data;
		$calc_global_data = self::$calc_global_data;

		$currency_settings = $calc_data['currency'] ?? array();

		if ( ! empty( $calc_global_data['currency']['use_in_all'] ) ) {
			$currency_settings = $calc_global_data['currency'];
		}

		$currency_sign      = $currency_settings['currency'] ?? '';
		$thousand_separator = $currency_settings['thousands_separator'] ?? '';
		$decimal_point      = $currency_settings['decimal_separator'] ?? '';
		$decimals           = $currency_settings['num_after_integer'] ?? '';
		$position           = $currency_settings['currencyPosition'] ?? '';

		return self::currencyConvertor( $total, $currency_sign, $thousand_separator, $decimal_point, $decimals, $position );
	}

	private static function get_calc_currency_sign() {
		$calc_data        = self::$calc_data;
		$calc_global_data = self::$calc_global_data;

		$currency_settings = $calc_data['currency'] ?? array();

		if ( ! empty( $calc_global_data['currency']['use_in_all'] ) ) {
			$currency_settings = $calc_global_data['currency'];
		}

		return $currency_settings['currency'] ?? '';
	}

	public static function currencyConvertor( $value, $currency_sign = '$', $thousand_separator = ',', $decimal_point = '.', $decimals = 2, $position = 'left' ) {
		$formattedValue = number_format( $value, $decimals, $decimal_point, $thousand_separator );

		switch ( $position ) {
			case 'left_with_space':
				return $currency_sign . ' ' . $formattedValue;
			case 'right_with_space':
				return $formattedValue . ' ' . $currency_sign;
			case 'right':
				return $formattedValue . $currency_sign;
			case 'left':
			default:
				return $currency_sign . $formattedValue;
		}
	}

	private static function set_calc_data( $calc_id ) {
		self::$calc_data        = CCBSettingsData::get_calc_single_settings( $calc_id );
		self::$calc_global_data = CCBSettingsData::get_calc_global_settings();
	}

	private static function total_in_totals_after_discounts_applied( $totals, $promocodes ) {
		foreach ( $totals as $idx => $total ) {
			if ( ! empty( $total['before_total_parse'] ) ) {
				$formula = $total['before_total_parse'];

				foreach ( $totals as $inner_total ) {
					$formula = preg_replace( '/\b' . preg_quote( $inner_total['alias'], '/' ) . '\b/', $inner_total['total'] ?? 0, $formula );
				}

				$total['total']             = self::evaluateFormula( $formula );
				$total['converted']         = self::currency_convertor( $total['total'] );
				$total['summary']           = $total['total'];
				$total['summary_converted'] = $total['converted'];
				$total['value']             = $total['converted'];

				if ( ! empty( $total['hasDiscount'] ) ) {
					$total                       = self::discount_for_single_total( $total, $promocodes );
					$total['skip_next_discount'] = true;
				}

				$totals[ $idx ] = $total;
			}
		}

		return $totals;
	}

	private static function separate_totals( $totals ) {
		$data = array(
			'totals'       => array(),
			'other_totals' => array(),
		);

		$payment_totals = array();
		foreach ( self::$payment_totals as $payment_total ) {
			$payment_totals[ $payment_total['alias'] ] = $payment_total;
		}

		foreach ( $totals as $total ) {
			if ( ! empty( $payment_totals[ $total['alias'] ] ) ) {
				$data['totals'][] = $total;
			} else {
				$data['other_totals'][] = $total;
			}
		}

		if ( 0 === count( $data['totals'] ) && count( $data['other_totals'] ) > 0 ) {
			$data['totals'][] = $data['other_totals'][0];

			$new_other_totals = array();
			foreach ( $data['other_totals'] as $idx => $other_total ) {
				if ( 0 !== intval( $idx ) ) {
					$new_other_totals[] = $other_total;
				}
			}

			$data['other_totals'] = $new_other_totals;
		}

		return $data;
	}

	private static function parse_conditions( $calc_id, $fields, $totals, $promocodes ) {
		$conditions = apply_filters( 'calc_render_conditions', array(), $calc_id );

		$mapped_fields = array();
		foreach ( $fields as $field ) {
			$mapped_fields[ $field['alias'] ] = $field;
		}

		$mapped_totals = array();
		foreach ( $totals as $total ) {
			$total['originalValue']           = $total['total'];
			$mapped_totals[ $total['alias'] ] = $total;
			$mapped_fields[ $total['alias'] ] = $total;
		}

		if ( ! empty( $conditions['links'] ) ) {
			foreach ( $conditions['links'] as $link ) {
				$option_to = $link['options_to'] ?? '';
				if ( ! isset( $mapped_totals[ $option_to ] ) ) {
					continue;
				}

				$hide = false;

				foreach ( $link['condition'] as $link_condition ) {
					$action     = $link_condition['action'] ?? '';
					$from_alias = $link_condition['optionFrom'] ?? '';
					$expression = '';

					if ( 0 < count( $link_condition['conditions'] ) ) {
						$value = $mapped_fields[ $from_alias ]['summary_value'] ?? 0;
						if ( ! isset( $mapped_fields[ $from_alias ]['summary_value'] ) && ! empty( $mapped_fields[ $from_alias ]['originalValue'] ) ) {
							$value = $mapped_fields[ $from_alias ]['originalValue'];
						}

						$length = count( $link_condition['conditions'] );

						foreach ( $link_condition['conditions'] as $idx => $condition ) {
							$operand = $condition['condition'];
							$values  = self::get_field_value_based_on_condition( $from_alias, $mapped_fields, $value, $operand );
							$value   = $values['value'] ?? $value;

							$c_value = self::get_condition_value_based_on_condition( $from_alias, $operand, $condition );

							$expression .= self::generate_condition_expression( $value, $operand, $c_value, $from_alias, $values );

							if ( 1 !== $length && ( $length - 1 ) !== $idx ) {
								$expression .= ' ' . $condition['logicalOperator'] . ' ';
							}
						}

						$result = self::evaluateFormula( $expression );
						$hide   = $result && 'hide' === $action;

						if ( 'show' === $action && ! $result ) {
							$hide = true;
						}
					}
				}

				if ( $hide ) {
					$option_to                             = $link['options_to'] ?? '';
					$mapped_totals[ $option_to ]['hidden'] = 1;
				} elseif ( isset( $mapped_fields[ $from_alias ] ) ) {
					$mapped_totals[ $option_to ]['hidden'] = '';
				}
			}
		}

		foreach ( $mapped_totals as $alias => $total ) {
			if ( ! empty( $total['before_total_parse'] ) ) {
				$formula = $total['before_total_parse'];
				foreach ( $mapped_totals as $inner_total ) {
					$value = $inner_total['total'];
					if ( ! empty( $inner_total['hidden'] ) && empty( $inner_total['calculateHidden'] ) ) {
						$value = 0;
					}

					$formula = preg_replace( '/\b' . preg_quote( $inner_total['alias'], '/' ) . '\b/', $value, $formula );
				}

				$total['total']             = self::evaluateFormula( $formula );
				$total['formula']           = $formula;
				$total['converted']         = self::currency_convertor( $total['total'] );
				$total['summary']           = $total['total'];
				$total['summary_converted'] = $total['converted'];
				$total['value']             = $total['converted'];

				if ( ! empty( $total['hasDiscount'] ) ) {
					$total = self::discount_for_single_total( $total, $promocodes );
				}

				$mapped_totals[ $alias ] = $total;
			}
		}

		foreach ( $mapped_totals as $alias => $total ) {
			if ( ! empty( $total['hidden'] ) && empty( $total['calculateHidden'] ) ) {
				unset( $mapped_totals[ $alias ] );
			}
		}

		return array_values( $mapped_totals );
	}

	private static function generate_default_formula( $fields, $order_details ) {
		if ( empty( self::$default_total ) ) {
			$ids = array();
			foreach ( $fields as $field ) {
				$ids[] = intval( $field['_id'] );
			}

			$max_id  = max( $ids ) + 1;
			$formula = '';

			foreach ( $order_details as $idx => $detail ) {
				$alias = $detail['alias'] ?? '';
				if ( ! empty( $alias ) ) {
					$formula .= $alias;
					if ( ( count( $order_details ) - 1 ) !== $idx ) {
						$formula .= ' + ';
					}
				}
			}

			self::$default_total = array(
				'id'          => $max_id,
				'label'       => 'Total',
				'alias'       => 'total_field_id_' . $max_id,
				'formula'     => $formula,
				'hasDiscount' => '',
			);
		}

		return self::$default_total;
	}

	private static function js_to_php( $jsCode ) {
		// phpcs:disable
		$phpCode = str_replace( array( "&&", "||" ), array( "and", "or" ), $jsCode );

		$phpCode = preg_replace( array(
			'/Math\.sqrt\((.*?)\)/',
			'/Math\.ceil\((.*?)\)/',
			'/Math\.abs\((.*?)\)/',
			'/Math\.pow\((.*?),\s*(.*?)\)/',
			'/Math\.round\((.*?)\)/',
			'/Math\.floor\((.*?)\)/',
			'/Math\.min\((.*?)\)/',
			'/Math\.max\((.*?)\)/'
		), array(
			'sqrt($1)',
			'ceil($1)',
			'abs($1)',
			'pow($1, $2)',
			'round($1)',
			'floor($1)',
			'min($1)',
			'max($1)'
		), $phpCode );

		if ( ! str_contains( $phpCode, 'if' ) ) {
			return eval( "return " . trim( $phpCode ) . ";" ); // phpcs:ignore
		}

		$phpCode = preg_replace( array(
			'/if\s*\((.*?)\)\s*\{/',
			'/\}else if\s*\((.*?)\)\s*\{/',
			'/\}else\s*\{/',
			'/\}$/',
		), array(
			'if ($1) { ',
			'} elseif ($1) { ',
			'} else { ',
			'}',
		), $phpCode);

		$phpCode = preg_replace_callback('/\{([^{}]+)\}/', function ( $matches ) {
			return "{ \$result = " . trim( $matches[1] ) . "; }";
		}, $phpCode);

		$wrappedCode = "\$result = null; " . $phpCode . " return \$result;";

		return eval( $wrappedCode );
		// phpcs:enable
	}


	private static function get_field_value_based_on_condition( $from_alias, $mapped_fields, $value, $condition ) {
		$field_name = preg_replace( '/_field_id.*/', '', $from_alias );
		$temps      = array();

		if ( in_array( $field_name, array( 'radio', 'dropDown', 'dropDown_with_img', 'radio_with_img' ), true ) && '==' === $condition ) {
			$temps = $mapped_fields[ $from_alias ]['temps'] ?? array();
			foreach ( $temps as $temp ) {
				$parts = explode( '_', $temp );
				$value = (int) end( $parts );
			}
		}

		if ( in_array( $field_name, array( 'checkbox', 'toggle', 'checkbox_with_img' ), true ) && in_array( $condition, array( 'in', '==', 'contains', 'not in' ), true ) ) {
			$temps      = $mapped_fields[ $from_alias ]['temps'] ?? array();
			$value      = array();
			$temp_value = 0;
			foreach ( $temps as $temp ) {
				$parts = explode( '_', $temp );
				if ( '==' === $condition ) {
					$temp_value += (int) reset( $parts );
				} else {
					$value[] = (int) end( $parts );
				}
			}

			if ( '==' === $condition ) {
				$value = $temp_value;
			}
		}

		return array(
			'value' => $value,
			'temps' => $temps,
		);
	}

	private static function get_condition_value_based_on_condition( $from_alias, $operand, $condition ) {
		$field_name = preg_replace( '/_field_id.*/', '', $from_alias );
		$value      = $condition['value'];

		if ( in_array( $field_name, array( 'radio', 'dropDown', 'dropDown_with_img', 'radio_with_img' ), true ) && '==' === $operand ) {
			$value = $condition['key'];
		}

		if ( in_array( $field_name, array( 'checkbox', 'toggle', 'checkbox_with_img' ), true ) && in_array( $operand, array( 'in', 'contains', 'not in' ), true ) ) {
			if ( 'in' === $operand || 'not in' === $operand ) {
				$value = $condition['checkedValues'];
			} else {
				$value = $condition['key'];
			}
		}

		return $value;
	}

	private static function generate_condition_expression( $left_value, $operand, $right_value, $from_alias, $values = array() ) {
		$field_name = preg_replace( '/_field_id.*/', '', $from_alias );
		if ( in_array( $field_name, array( 'checkbox', 'toggle', 'checkbox_with_img' ), true ) && in_array( $operand, array( 'in', 'contains', 'not in' ), true ) ) {
			$expression = '';
			if ( 'in' === $operand ) {
				if ( count( $left_value ) !== count( $right_value ) ) {
					return '0';
				}

				foreach ( $left_value as $idx => $v ) {
					$res         = in_array( $v, $right_value, true );
					$expression .= false === $res ? '0' : '1';

					if ( count( $left_value ) - 1 !== $idx ) {
						$expression .= ' && ';
					}
				}
			} elseif ( 'contains' === $operand ) {
				$res         = in_array( $right_value, $left_value, true );
				$expression .= false === $res ? '0' : '1';
			} elseif ( 'not in' === $operand ) {
				if ( empty( $left_value ) ) {
					return '1';
				}

				foreach ( $right_value as $idx => $v ) {
					$res         = in_array( $v, $left_value, true );
					$expression .= false === $res ? '1' : '0';

					if ( count( $right_value ) - 1 !== $idx ) {
						$expression .= ' && ';
					}
				}
			}

			return $expression;
		}

		if ( 'any' === $right_value ) {
			if ( ! empty( $values['temps'] ) ) {
				return ! empty( $values['temps'][0] ) ? '1' : '';
			}

			return '';
		}

		return $left_value . ' ' . $operand . ' ' . $right_value;
	}

	private static function discount_for_single_total( $total_field, $promocodes ) {
		if ( ! empty( self::$discounts ) && count( self::$discounts ) > 0 ) {
			foreach ( self::$discounts as $discount ) {
				if ( ! empty( $discount['conditions'] ) ) {

					$promocode = $discount['promocode'] ?? '';
					if ( ! empty( $discount['is_promo'] ) && ! empty( $promocode ) && ! in_array( $promocode, $promocodes, true ) ) {
						continue;
					}

					foreach ( $discount['conditions'] as $condition ) {
						$field_aliases = explode( ',', $condition['field_alias'] );

						if ( ! empty( $field_aliases ) ) {
							if ( in_array( $total_field['alias'], $field_aliases, true ) ) {
								$result  = eval( 'return ' . $total_field['total'] . $condition['condition_symbol'] . $condition['over_price'] . ';' ); //phpcs:ignore
								if ( $result && ! empty( $condition['discount_type'] ) ) {
									$new_total          = $total_field['summary'];
									$original_total     = $total_field['summary'];
									$original_converted = $total_field['summary_converted'];

									if ( 'percent_of_amount' === $condition['discount_type'] ) {
										$val = $new_total * ( $condition['discount_amount'] / 100 );
										$val = $new_total - $val;
									} else {
										$val = $new_total - intval( $condition['discount_amount'] );
									}

									//phpcs:disable
									$total_field['discount'] = array(
										'discountView'       => $discount['view_type'],
										'discountTitle'      => $discount['title'],
										'discountAmount'     => $condition['discount_amount'],
										'discountType'       => $condition['discount_type'],
										'discountValue'      => self::currency_convertor( $condition['discount_amount'] ),
										'hasDiscount'        => '1',
										'isPromo'            => $discount['is_promo'],
										'currency'           => 'percent_of_amount' === $condition['discount_type'] ? '%' : self::get_calc_currency_sign(),
										'original_value'     => $original_total,
										'original_converted' => $original_converted,
									);
									//phpcs:enable

									$new_total                  = max( $val, 0 );
									$total_field['total']       = $new_total;
									$total_field['value']       = $new_total;
									$total_field['converted']   = self::currency_convertor( $new_total );
									$total_field['hasDiscount'] = 1;
								}
							}
						}
					}
				}
			}
		}

		return $total_field;
	}

	public static function set_measuring_unit( $totals, $from_order = false ) {
		foreach ( $totals as $key => $total ) {
			if ( ! empty( $total['fieldCurrency'] ) ) {
				$currency_sign      = $total['fieldCurrencySettings']['currency'];
				$thousand_separator = $total['fieldCurrencySettings']['thousands_separator'];
				$decimal_point      = $total['fieldCurrencySettings']['decimal_separator'];
				$decimals           = $total['fieldCurrencySettings']['num_after_integer'];
				$position           = $total['fieldCurrencySettings']['currencyPosition'];
				$new_total          = self::currencyConvertor( $total['total'], $currency_sign, $thousand_separator, $decimal_point, $decimals, $position );
				$new_summary        = self::currencyConvertor( $total['summary'], $currency_sign, $thousand_separator, $decimal_point, $decimals, $position );

				if ( $from_order ) {
					$totals[ $key ]['paymentCurrency']     = $currency_sign;
					$totals[ $key ]['num_after_integer']   = $decimals;
					$totals[ $key ]['thousands_separator'] = $thousand_separator;
					$totals[ $key ]['decimal_separator']   = $decimal_point;
					$totals[ $key ]['currency_position']   = $position;
				}

				if ( ! empty( $total['hasDiscount'] ) ) {
					$totals[ $key ]['discount']['original_converted'] = $new_summary;
				}

				$totals[ $key ]['converted']         = $new_total;
				$totals[ $key ]['summary_converted'] = $new_summary;
				$totals[ $key ]['value']             = $new_summary;
			}
		}

		return $totals;
	}
}

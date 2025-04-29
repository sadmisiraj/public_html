<?php

namespace cBuilder\Classes;

use cBuilder\Classes\Database\Orders;

class CCBContactForm {
	public static function render() {
		check_ajax_referer( 'ccb_contact_form', 'nonce' );
		$result = array(
			'status'  => 'error',
			'success' => false,
			'message' => apply_filters( 'ccb_contact_form_invalid_error', __( 'Something went wrong', 'cost-calculator-builder-pro' ) ),
		);

		if ( ! isset( $_POST['action'] ) || 'calc_contact_form' !== $_POST['action'] ) {
			return $result;
		}

		$params = '';

		$data = null;
		if ( isset( $_POST['data'] ) ) {
			$data = ccb_convert_from_btoa( $_POST['data'] );

			if ( ! ccb_is_convert_correct( $data ) ) {
				$result['message'] = 'Invalid data';
				wp_send_json( $result );
			}
		}

		if ( is_string( $data ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$params = str_replace( '\\n', '^n', $data ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
			$params = str_replace( '\\\"', 'ccb_quote', $params );
			$params = str_replace( '\\', '', $params );
			$params = str_replace( 'ccb_quote', '\"', $params );
			$params = str_replace( '^n', '\\n', $params );

			$params = json_decode( $params, true );

			$order_id    = $params['orderId'] ?? '';
			$order_data  = CCBOrderController::get_orders_by_id( $order_id );
			$meta_data   = get_option( 'calc_meta_data_order_' . $order_id, array() );
			$calc_totals = json_decode( $meta_data['totals'], true );
			$otherTotals = json_decode( $meta_data['otherTotals'], true );

			$params['item_name']           = $order_data['calc_title'] ?? '';
			$params['calcTotals']          = $calc_totals ?? array();
			$params['calcTotalsConverted'] = $calc_totals ?? array();
			$params['otherTotals']         = $otherTotals ?? array();
		}

		if ( isset( $params['captchaSend'] ) ) {
			if ( isset( $params['captcha'] ) && ! empty( $params['captcha']['token'] ) ) {
				$token    = $params['captcha']['token'];
				$captcha  = $params['captcha']['v3'];
				$secret   = $captcha['secretKey'];
				$url      = 'https://www.google.com/recaptcha/api/siteverify?secret=' . rawurlencode( $secret ) . '&response=' . rawurlencode( $token );
				$response = file_get_contents( $url ); // phpcs:ignore
				$response = json_decode( $response );

				if ( ! $response->success ) {
					wp_send_json( $result );
				}
			} else {
				wp_send_json( $result );
			}
		}

		$general_settings = CCBSettingsData::get_calc_global_settings();
		$settings         = CCBSettingsData::get_calc_single_settings( $params['calcId'] );

		$subject    = $settings['formFields']['emailSubject'];
		$user_email = $settings['formFields']['adminEmailAddress'];
		if ( ! empty( $general_settings['form_fields']['use_in_all'] ) ) {
			$subject    = $general_settings['form_fields']['emailSubject'];
			$user_email = $general_settings['form_fields']['adminEmailAddress'];
		}

		$client_email  = $params['clientEmail'] ?? '';
		$custom_emails = $params['customEmails'] ?? '';

		if ( ! filter_var( $user_email, FILTER_VALIDATE_EMAIL ) || ! filter_var( $client_email, FILTER_VALIDATE_EMAIL ) ) {
			return array(
				'success' => false,
				'message' => apply_filters( 'ccb_contact_form_email_error', __( 'Something went wrong', 'cost-calculator-builder-pro' ) ),
			);
		}

		$subject     = empty( $subject ) ? $_SERVER['REQUEST_URI'] : $subject;
		$attachments = array();

		$subject = apply_filters( 'cbb_email_subject', $subject, $params['calcId'] );

		/** upload files, get  $file_urls */
		$file_urls = self::add_files( $params );

		if ( count( $file_urls ) > 0 ) {
			foreach ( $file_urls as $file_item ) {
				$attachments = array_merge( $attachments, array_column( $file_item, 'file' ) );
			}
		}

		$attachments = apply_filters( 'ccb_email_attachment', $attachments, $params );
		$fields      = array_map(
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

					if ( isset( $field['groupElements'] ) ) {
						foreach ( $field['groupElements'] as $key => $childElement ) {
							if ( strpos( $childElement['alias'], $allowed ) !== false ) {
								$childElement['has_options']    = true;
								$field['groupElements'][ $key ] = $childElement;
							}
						}
					}
				}
				return $field;
			},
			$params['descriptions']
		);

		$fields = array_filter(
			$fields,
			function ( $field ) {
				return ! str_contains( $field['alias'], 'group' );
			}
		);

		$discount_data = array();
		if ( ! empty( $params['orderId'] ) ) {
			$discount_data = Orders::get_order_discounts( $params['orderId'] );
		}

		$add_order_id_to_subject = isset( $params['addOrderIdToSubject'] ) ? $params['addOrderIdToSubject'] : false;

		$totals = $discount_data['totals'] ?? $params['calcTotals'];
		foreach ( $totals as $key => $total ) {
			if ( ! empty( $total['fieldCurrency'] ) ) {
				$currency_sign      = $total['fieldCurrencySettings']['currency'];
				$thousand_separator = $total['fieldCurrencySettings']['thousands_separator'];
				$decimal_point      = $total['fieldCurrencySettings']['decimal_separator'];
				$decimals           = $total['fieldCurrencySettings']['num_after_integer'];
				$position           = $total['fieldCurrencySettings']['currencyPosition'];

				$totals[ $key ]['converted'] = CCBCalculator::currencyConvertor( $total['total'], $currency_sign, $thousand_separator, $decimal_point, $decimals, $position );
			}
		}

		$args = array(
			'fields'         => $fields,
			'send_fields'    => $params['sendFields'],
			'totals'         => $totals,
			'other_totals'   => isset( $params['otherTotals'] ) ? $params['otherTotals'] : array(),
			'email_settings' => $general_settings['email_templates'],
			'files'          => $file_urls,
			'show_unit'      => $params['showUnit'] ?? '',
			'calc_id'        => $params['calcId'],
			'order_id'       => $params['orderId'],
			'promocodes'     => $discount_data['promocodes'] ?? array(),
		);

		$args['totals']       = array_filter( $args['totals'] );
		$args['other_totals'] = array_filter( $args['other_totals'] );

		$result = self::sendEmail(
			array(
				'args'                    => $args,
				'calcId'                  => $params['calcId'],
				'client_email'            => $client_email,
				'subject'                 => $subject,
				'attachments'             => $attachments,
				'user_email'              => $user_email,
				'custom_emails'           => $custom_emails,
				'add_order_id_to_subject' => $add_order_id_to_subject,
			),
			$result
		);

		wp_send_json( $result );
	}

	/** check uploaded files based on settings ( file upload field ) */
	protected static function validateFile( $file, $field_id, $calc_id ) { // phpcs:ignore
		if ( empty( $file ) ) {
			return false;
		}

		$file_upload_field = null;
		$calc_fields       = get_post_meta( $calc_id, 'stm-fields', true );
		preg_match( '/(_\d+)$/', $field_id, $key );

		foreach ( $calc_fields as $field ) {
			if ( ! empty( $field['alias'] ) && $field_id === $field['alias'] ) {
				$file_upload_field = $field;
			} elseif ( ! empty( $field['alias'] ) && ! empty( $field['groupElements'] ) ) {
				foreach ( $field['groupElements'] as $_field ) {
					if ( ! empty( $_field['alias'] ) ) {
						$possible_aliases = array( $_field['alias'], $_field['alias'] . $key[0] );
						if ( in_array( $field_id, $possible_aliases, true ) ) {
							$file_upload_field = $_field;
						}
					}

					if ( ! empty( $_field['groupElements'] ) ) {
						foreach ( $_field['groupElements'] as $__field ) {
							if ( ! empty( $__field['alias'] ) ) {
								$possible_aliases = array( $__field['alias'], $__field['alias'] . $key[0] );
								if ( in_array( $field_id, $possible_aliases, true ) ) {
									$file_upload_field = $__field;
								}
							}
						}
					}
				}
			}
		}

		$extension       = pathinfo( $file['name'], PATHINFO_EXTENSION );
		$allowed_formats = array();

		if ( isset( $file_upload_field['fileFormats'] ) ) {
			foreach ( $file_upload_field['fileFormats'] as $format ) {
				$allowed_formats = array_merge( $allowed_formats, explode( '/', $format ) );
			}
		}

		/** check file extension */
		if ( ! in_array( $extension, $allowed_formats, true ) ) {
			return false;
		}

		/** check file size */
		if ( $file_upload_field['max_file_size'] < round( $file['size'] / 1024 / 1024, 1 ) ) {
			return false;
		}

		return true;
	}

	public static function add_files( $params ) {
		/** upload files if exist */
		if ( ! is_array( $_FILES ) ) {
			return $params;
		}

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$file_urls     = array();
		$order_details = array();

		foreach ( $params['descriptions'] as $detail ) {
			if ( ! empty( $detail['alias'] ) && str_contains( $detail['alias'], 'repeater' ) ) {
				foreach ( $detail['groupElements'] as $item ) {
					$order_details[] = $item;
				}
			} else {
				$order_details[] = $detail;
			}
		}

		/** upload all files, create array for fields */
		foreach ( $_FILES as $file_key => $file ) {
			$field_id          = preg_replace( '/_ccb_.*/', '', $file_key );
			$file_upload_field = null;
			preg_match( '/(_\d+)$/', $field_id, $key );

			foreach ( $order_details as $field ) {
				if ( isset( $field['alias'] ) && ! empty( $field['alias'] ) ) {
					$possible_aliases = array( $field['alias'], $field['alias'] . $key[0] );

					if ( in_array( $field_id, $possible_aliases, true ) ) {
						$file_upload_field = $field;
					}
				}
			}

			/** if field not found continue */
			if ( is_null( $file_upload_field ) ) {
				continue;
			}

			/** validate file by settings */
			$is_valid = self::validateFile( $file, $field_id, $params['calcId'] );
			if ( ! $is_valid ) {
				continue;
			}

			if ( empty( $file_urls[ $field_id ] ) ) {
				$file_urls[ $field_id ] = array();
			}

			$upload_dir   = wp_upload_dir();
			$image_info   = getimagesize( $file['tmp_name'] );
			$file['name'] = sanitize_file_name( $file['name'] );

			if ( isset( $image_info['mime'] ) ) {
				$file_name = pathinfo( $file['name'], PATHINFO_FILENAME ) . ccb_get_format_by_mime( $image_info['mime'] );
			} else {
				$file_name = $file['name'];
			}

			$file_path = $upload_dir['path'] . '/' . $file_name;

			if ( file_exists( $file_path ) ) {
				$file_info = array(
					'url'      => trailingslashit( $upload_dir['url'] ) . $file_name,
					'file'     => $file_path,
					'size'     => filesize( $file_path ),
					'type'     => mime_content_type( $file_path ),
					'filename' => $file_name,
				);
			} else {
				$file_info = wp_handle_upload( $file, array( 'test_form' => false ) );
			}

			if ( ! empty( $file_info['file'] ) && str_contains( $file['type'], 'svg' ) ) {
				$svg_sanitizer = new \enshrined\svgSanitize\Sanitizer();
				$dirty_svg     = file_get_contents( $file_info['file'] ); //phpcs:ignore
				$clean_svg     = $svg_sanitizer->sanitize( $dirty_svg );
				file_put_contents( $file_info['file'], $clean_svg ); //phpcs:ignore
			}

			if ( $file_info && empty( $file_info['error'] ) ) {
				$file_info['filename']    = $file['name'];
				$file_urls[ $field_id ][] = $file_info;
			}
		}
		return $file_urls;
	}

	public static function sendEmail( $params = array(), $result = array() ) {
		$other_totals                   = $params['args']['other_totals'] ?? array();
		$totals                         = $params['args']['totals'] ?? array();
		$params['args']['totals']       = array();
		$params['args']['other_totals'] = array();

		foreach ( $totals as $total ) {
			if ( empty( $total['hidden'] ) ) {
				$params['args']['totals'][] = $total;
			}
		}

		foreach ( $other_totals as $total ) {
			if ( empty( $total['hidden'] ) ) {
				$params['args']['other_totals'][] = $total;
			}
		}

		$general_settings = CCBSettingsData::get_calc_global_settings();
		$email_from_name  = $general_settings['invoice']['fromName'] ?? '';
		$email_from       = ! empty( $general_settings['invoice']['fromEmail'] ) ? $general_settings['invoice']['fromEmail'] : get_option( 'admin_email' );
		$headers          = 'From: ' . $email_from_name .  ' <' . $email_from . '>' . "\r\n"; //phpcs:ignore
		$headers         .= 'Content-Type: text/html; charset=UTF-8';
		$headers          = apply_filters( 'ccb_email_header', $headers, $params['args'] );

		do_action( 'ccb_contact_form_message_template_before', $params['args'], $params['calcId'] );

		$body_client = apply_filters( 'ccb_email_body_client', CCBProTemplate::load( 'admin/email-templates/customer-email-template', $params['args'] ) );
		$body_user   = apply_filters( 'ccb_email_body_user', CCBProTemplate::load( 'admin/email-templates/owner-email-template', $params['args'] ) );

		do_action( 'ccb_contact_form_message_template_formed', $body_client, $body_user );

		$subject = isset( $params['add_order_id_to_subject'] ) && $params['add_order_id_to_subject'] ? '#' . $params['args']['order_id'] . ' | ' . $params['subject'] : $params['subject'];

		$to_user_email   = null;
		$to_client_email = wp_mail( $params['client_email'], $subject, $body_client, $headers, $params['attachments'] );

		if ( $to_client_email ) {
			$custom_emails       = array();
			$custom_emails[]     = $params['user_email']; // Add the user's email to the $custom_emails array
			$custom_emails[]     = implode( ',', $params['custom_emails'] );
			$all_email_receivers = implode( ',', $custom_emails ); // Create a comma-separated string of email addresses
			$to_user_email       = wp_mail( $all_email_receivers, $subject, $body_user, $headers, $params['attachments'] );
		}

		if ( $to_user_email && $to_client_email ) {
			$result['success'] = true;
			$result['message'] = __( 'Thank you for your message. It has been sent.', 'cost-calculator-builder-pro' );
		}

		do_action( 'ccb_contact_form_sent', $result );

		return $result;
	}
}

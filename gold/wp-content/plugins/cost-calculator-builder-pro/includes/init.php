<?php
/**
 * add ajax action
 */
add_action(
	'init',
	function () {

		if ( ! is_textdomain_loaded( 'cost-calculator-builder-pro' ) ) {
			$mo_file_path = CCB_PRO_PATH . '/languages/cost-calculator-builder-pro-' . determine_locale() . '.mo';
			load_textdomain( 'cost-calculator-builder-pro', $mo_file_path );
		}

		if ( isset( $_GET['stm_ccb_check_ipn'] ) && strval( $_GET['stm_ccb_check_ipn'] ) === "1" ) { // phpcs:ignore
			\cBuilder\Classes\Payments\CCBPayPal::check_payment( $_REQUEST );
		}

		\cBuilder\Classes\CCBProSettings::init();
		\cBuilder\Classes\CCBProSettings::init();
		\cBuilder\Classes\CCBProAjaxActions::init();
		\cBuilder\Classes\CCBWooProducts::init();
		\cBuilder\Classes\CCBWebhooks::init();
	}
);

add_filter(
	'upload_mimes',
	function ( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
		$mimes['cdr']  = 'application/x-coreldraw';
		$mimes['ai']   = 'application/postscript';
		return $mimes;
	}
);

add_filter(
	'wp_check_filetype_and_ext',
	function ( $checked, $file, $filename, $mimes ) {
		if ( ! $checked['type'] ) {
			$ext = pathinfo( $filename, PATHINFO_EXTENSION );
			if ( 'cdr' === $ext ) {
				$checked = array(
					'ext'             => 'cdr',
					'type'            => 'application/x-coreldraw',
					'proper_filename' => $filename,
				);
			} elseif ( 'ai' === $ext ) {
				$checked = array(
					'ext'             => 'ai',
					'type'            => 'application/postscript',
					'proper_filename' => $filename,
				);
			}
		}
		return $checked;
	},
	10,
	4
);

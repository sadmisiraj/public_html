<?php

namespace cBuilder\Classes;

class CCBWpHooks {
	public static function return_demo_response() {
		check_ajax_referer( 'ccb_wp_hook_nonce', 'nonce' );

		$result = array(
			'message' => 'Action is executed successfully',
			'success' => true,
		);

		wp_send_json( $result );
	}

}

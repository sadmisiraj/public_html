<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

use Requests;

class Webhook extends Entity {
	public function create( $attributes = array() ) {
		return parent::create( $attributes );
	}

	public function fetch( $id ) {
		return parent::fetch( $id );
	}

	public function all( $options = array() ) {
		return parent::all( $options );
	}

	public function edit( $attributes = array(), $id ) {
		$url = $this->getEntityUrl() . $id;

		return $this->request( Requests::PUT, $url, $attributes );
	}
}

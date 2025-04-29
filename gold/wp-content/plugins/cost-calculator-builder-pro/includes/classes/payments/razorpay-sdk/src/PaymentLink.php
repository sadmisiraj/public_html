<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

use Requests;


class PaymentLink extends Entity {
	public function create( $attributes = array() ) {
		$attributes = json_encode( $attributes );

		Request::addHeader( 'Content-Type', 'application/json' );

		return parent::create( $attributes );
	}

	public function fetch( $id ) {
		return parent::fetch( $id );
	}

	public function all( $options = array() ) {
		return parent::all( $options );
	}

	public function cancel() {
		$url = $this->getEntityUrl() . $this->id . '/cancel';

		return $this->request( Requests::POST, $url );
	}

	public function edit( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . $this->id;
		
		$attributes = json_encode( $attributes );

		Request::addHeader( 'Content-Type', 'application/json' );

		return $this->request( 'PATCH', $relativeUrl, $attributes );
	}

	public function notifyBy( $medium ) {
		$url = $this->getEntityUrl() . $this->id . '/notify_by/' . $medium;
		$r   = new Request();

		return $r->request( Requests::POST, $url );
	}
}

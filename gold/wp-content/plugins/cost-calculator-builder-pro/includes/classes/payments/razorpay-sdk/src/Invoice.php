<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

use Requests;

/**
 * Invoice entity gets used for both Payment Links and Invoices system.
 * Few of the methods are only meaningful for Invoices system and calling those
 * for against/for a Payment Link would throw Bad request error.
 */
class Invoice extends Entity {
	public function create( $attributes = array() ) {
		return parent::create( $attributes );
	}

	public function fetch( $id ){
		return parent::fetch( $id );
	}

	public function all( $options = array() ) {
		return parent::all( $options );
	}

	public function cancel() {
		$url = $this->getEntityUrl() . $this->id . '/cancel';
		return $this->request( Requests::POST, $url );
	}

	public function notifyBy( $medium ) {
		$url = $this->getEntityUrl() . $this->id . '/notify_by/' . $medium;
		$r   = new Request();

		return $r->request( Requests::POST, $url );
	}

	public function edit( $attributes = array() ) {
		$url = $this->getEntityUrl() . $this->id;

		return $this->request( Requests::PATCH, $url, $attributes );
	}

	public function issue() {
		$url = $this->getEntityUrl() . $this->id . '/issue';
		return $this->request( Requests::POST, $url );
	}

	public function delete() {
		$url = $this->getEntityUrl() . $this->id;
		$r   = new Request();

		return $r->request( Requests::DELETE, $url );
	}
}

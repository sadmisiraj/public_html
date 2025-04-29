<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

class QrCode extends Entity {
	public function create( $attributes = array() ) {
		$relativeUrl = "payments/". $this->getEntityUrl();

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function fetch( $id ) {
		$relativeUrl = "payments/" . $this->getEntityUrl() . $id;

		return $this->request( 'GET', $relativeUrl );
	}

	public function close() {
		$relativeUrl = "payments/{$this->getEntityUrl()}{$this->id}/close"; // phpcs:ignore

		return $this->request( 'POST', $relativeUrl );
	}

	public function all($options = array()) {
		$relativeUrl = "payments/" . $this->getEntityUrl();

		return $this->request( 'GET', $relativeUrl, $options );
	}

	public function fetchAllPayments( $options = array() ) {
		$relativeUrl = "payments/{$this->getEntityUrl()}{$this->id}/payments"; // phpcs:ignore

		return $this->request( 'GET', $relativeUrl, $options );
	}
}

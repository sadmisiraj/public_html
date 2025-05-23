<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

use Requests;

class Payment extends Entity {
	public function fetch( $id ) {
		return parent::fetch( $id );
	}

	public function all( $options = array() ) {
		if( isset( $options['X-Razorpay-Account'] ) ) {

			Request::addHeader( 'X-Razorpay-Account', $options['X-Razorpay-Account'] );

			unset( $options[ 'X-Razorpay-Account' ] );
		}

		return parent::all( $options );
	}

	public function edit( $attributes = array() ) {
		$url = $this->getEntityUrl() . $this->id;

		return $this->request( Requests::PATCH, $url, $attributes );
	}

	public function refund( $attributes = array() ) {
		$refund = new Refund;

		$attributes = array_merge( $attributes, array( 'payment_id' => $this->id ) );

		return $refund->create( $attributes );
	}

	public function capture( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/capture';

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function transfer( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/transfers';

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function refunds() {
		$refund = new Refund;

		$options = array( 'payment_id' => $this->id );

		return $refund->all( $options );
	}

	public function transfers() {
		$transfer = new Transfer();

		$transfer->payment_id = $this->id;

		return $transfer->all();
	}

	public function bankTransfer() {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/bank_transfer';

		return $this->request( 'GET', $relativeUrl );
	}

	public function fetchMultipleRefund( $options = array() ) {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/refunds';

		return $this->request( 'GET', $relativeUrl, $options );
	}

	public function fetchRefund( $refundId ) {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/refunds/'.$refundId;

		return $this->request( 'GET', $relativeUrl );
	}

	public function createRecurring( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . 'create/recurring';

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function fetchCardDetails() {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/card';

		return $this->request( 'GET', $relativeUrl );
	}

	public function fetchPaymentDowntime() {
		$relativeUrl = $this->getEntityUrl() . 'downtimes';

		return $this->request( 'GET', $relativeUrl );
	}

	public function fetchPaymentDowntimeById( $id ) {
		$relativeUrl = $this->getEntityUrl() . 'downtimes' . $id;

		return $this->request( 'GET', $relativeUrl );
	}

	public function createPaymentJson( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . 'create/json';

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function otpSubmit( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/otp/submit';

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function otpGenerate() {
		$relativeUrl = $this->getEntityUrl() . $this->id . '/otp_generate';

		return $this->request( 'POST', $relativeUrl );
	}

}

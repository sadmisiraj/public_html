<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

/**
 * Settlement related actions can be done from here
 */
class Settlement extends Entity {
	public function createOndemandSettlement( $attributes = array() ) {
		$relativeUrl = $this->getEntityUrl() . "ondemand";

		return $this->request( 'POST', $relativeUrl, $attributes );
	}

	public function fetch( $id ) {
		return parent::fetch( $id );
	}

	public function all( $options = array() ) {
		return parent::all( $options );
	}

	public function reports( $options = array() ) {
		$relativeUrl = $this->getEntityUrl() . 'report/combined';

		return $this->request( 'GET', $relativeUrl, $options );
	}

	public function settlementRecon( $options = array() ) {
		$relativeUrl = $this->getEntityUrl() . 'recon/combined';

		return $this->request( 'GET', $relativeUrl, $options );
	}

	public function fetchOndemandSettlementById() {
		$relativeUrl = $this->getEntityUrl() . "ondemand/" . $this->id ;
	   
		return $this->request( 'GET', $relativeUrl );
	}

	public function fetchAllOndemandSettlement() {
		$relativeUrl = $this->getEntityUrl() . "ondemand/";
		
		return $this->request( 'GET', $relativeUrl );
	}
}

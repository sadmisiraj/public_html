<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

class Order extends Entity {
    public function create( $attributes = array() ) {
        return parent::create( $attributes );
    }

    public function fetch( $id ) {
        return parent::fetch( $id );
    }

    public function all( $options = array() ) {
        return parent::all( $options );
    }

    public function edit( $attributes = array() ) {
        $url = $this->getEntityUrl() . $this->id;
        return $this->request( 'PATCH', $url, $attributes );
    }

    public function payments() {
        $relativeUrl = $this->getEntityUrl() . $this->id . '/payments';
        return $this->request( 'GET', $relativeUrl );
    }

    public function transfers( $options = array() ) {
        $relativeUrl = $this->getEntityUrl() . $this->id;

        return $this->request( 'GET', $relativeUrl, $options );
    }
}

<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

use Razorpay\Api\Errors;

class Entity extends Resource implements ArrayableInterface
{
	protected $attributes = array();
	protected function create( $attributes = null ) {
		$entityUrl = $this->getEntityUrl();
		return $this->request( 'POST', $entityUrl, $attributes );
	}

	protected function fetch( $id ) {
		$entityUrl = $this->getEntityUrl();

		$this->validateIdPresence( $id );

		$relativeUrl = $entityUrl . $id;
	   
		return $this->request( 'GET', $relativeUrl );
	}

	protected function validateIdPresence( $id ) {
		if ( null !== $id ) {
			return;
		}

		$path  = explode( '\\', get_class( $this ) );
		$class = strtolower( array_pop( $path ) );

		$message = 'The ' . $class . ' id provided is null';

		$code = Errors\ErrorCode::BAD_REQUEST_ERROR;

		throw new Errors\BadRequestError( $message, $code, 500 );
	}

	protected function all( $options = array() ) {
		$entityUrl = $this->getEntityUrl();
		
		return $this->request( 'GET', $entityUrl, $options );
	}

	protected function getEntityUrl() {
		$fullClassName = get_class( $this );
		$pos           = strrpos( $fullClassName, '\\' );
		$className     = substr( $fullClassName, $pos + 1 );
		$className     = $this->snakeCase( $className);
		return $className.'s/';
	}

	protected function snakeCase( $input ) {
		$delimiter = '_';
		$output    = preg_replace( '/\s+/u', '', ucwords( $input ) );
		$output    = preg_replace( '/(.)(?=[A-Z])/u', '$1'.$delimiter, $output );
		$output    = strtolower( $output );
		return $output;
	}

	protected function request( $method, $relativeUrl, $data = null ) {
		$request = new Request();

		$response = $request->request( $method, $relativeUrl, $data );

		if ( ( isset( $response['entity'] ) ) and ($response['entity'] == $this->getEntity() ) ) { //phpcs:ignore
			$this->fill( $response );

			return $this;
		} else {
			return static::buildEntity( $response );
		}
	}

	protected static function buildEntity( $data ) {
		$entities = static::getDefinedEntitiesArray();

		if ( isset( $data['entity'] ) ) {
			if ( in_array( $data['entity'], $entities ) ) {
				$class  = static::getEntityClass( $data['entity'] );
				$entity = new $class;
			} else {
				$entity = new static;
			}
		} else {
			$entity = new static;
		}

		$entity->fill( $data );

		return $entity;
	}

	protected static function getDefinedEntitiesArray() {
		return array(
			'collection',
			'payment',
			'refund',
			'order',
			'customer',
			'token',
			'settlement',
		);
	}

	protected static function getEntityClass( $name ) {
		return __NAMESPACE__.'\\'.ucfirst( $name );
	}

	protected function getEntity() {
		$class  = get_class( $this );
		$pos    = strrpos( $class, '\\' );
		$entity = strtolower( substr( $class, $pos ) );

		return $entity;
	}

	public function fill( $data ) {
		$attributes = array();
		
	 if( is_array( $data ) ) {
		foreach ( $data as $key => $value) {
			if ( is_array( $value ) ) {
				if ( false === static::isAssocArray( $value ) ) {
					$collection = array();
					foreach ( $value as $v ) {
						if ( is_array( $v ) ) {
							$entity = static::buildEntity( $v );
							array_push( $collection, $entity );
						} else {
							array_push( $collection, $v );
						}
					}
					$value = $collection;
				} else {
					$value = static::buildEntity( $value );
				}
			}

			$attributes[ $key ] = $value;
		}
	  }
		$this->attributes = $attributes;
	}

	public static function isAssocArray( $arr ) {
		return array_keys( $arr ) !== range( 0, count( $arr ) - 1 );
	}

	public function toArray() {
		return $this->convertToArray( $this->attributes );
	}

	protected function convertToArray( $attributes ) {
		$array = $attributes;

		foreach ( $attributes as $key => $value ) {
			if ( is_object( $value ) ) {
				$array[ $key ] = $value->toArray();
			} elseif ( is_array( $value ) && false == self::isAssocArray( $value ) ) { // phpcs:ignore
				$array[ $key ] = $this->convertToArray( $value );
			}
		}

		return $array;
	}
}

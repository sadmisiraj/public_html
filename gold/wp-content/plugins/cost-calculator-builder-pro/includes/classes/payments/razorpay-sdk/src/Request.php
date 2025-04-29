<?php
// phpcs:ignoreFile

namespace Razorpay\Api;

use Requests;
use Exception;
use Requests_Hooks;
use Razorpay\Api\Errors;
use Razorpay\Api\Errors\ErrorCode;


// Available since PHP 5.5.19 and 5.6.3
// https://git.io/fAMVS | https://secure.php.net/manual/en/curl.constants.php
if ( ! defined( 'CURL_SSLVERSION_TLSv1_1 ') ) {
	define( 'CURL_SSLVERSION_TLSv1_1', 5 );
}

class Request {
	protected static $headers = array(
		'Razorpay-API' => 1,
	);

	public function request( $method, $url, $data = array() ) {
		$url = Api::getFullUrl( $url );

		$hooks = new Requests_Hooks();

		$hooks->register( 'curl.before_send', array( $this, 'setCurlSslOpts' ) );

		$options = array(
			'auth'    => array( Api::getKey(), Api::getSecret() ),
			'hook'    => $hooks,
			'timeout' => 60,
		);
		
		$headers = $this->getRequestHeaders();

		$response = Requests::request( $url, $headers, $data, $method, $options );
		$this->checkErrors( $response );

		return json_decode( $response->body, true );
	}

	public function setCurlSslOpts( $curl ) {
		curl_setopt( $curl, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_1 );
	}

	public static function addHeader( $key, $value ) {
		self::$headers[ $key ] = $value;
	}

	public static function getHeaders() {
		return self::$headers;
	}

	protected function checkErrors( $response ) {
		$body           = $response->body;
		$httpStatusCode = $response->status_code;

		try {
			$body = json_decode($response->body, true);
		} catch ( Exception $e ) {
			$this->throwServerError( $body, $httpStatusCode );
		}

		if ( ( $httpStatusCode < 200 ) || ( $httpStatusCode >= 300 ) ) { //phpcs:ignore
			$this->processError( $body, $httpStatusCode, $response );
		}
	}

	protected function processError( $body, $httpStatusCode, $response ) {
		$this->verifyErrorFormat( $body, $httpStatusCode );

		$code = $body['error']['code'];

		$error = str_replace( '_', ' ', $code );
		$error = ucwords( strtolower( $error ) );
		$error = str_replace( ' ', '', $error );

		$error = __NAMESPACE__.'\Errors\\' . $error;

		$description = $body['error']['description'];

		$field = null;
		if ( isset( $body['error']['field'] ) ) {
			$field = $body['error']['field'];

			throw new $error( $description, $code, $httpStatusCode, $field );
		}

		throw new $error( $description, $code, $httpStatusCode );
	}

	protected function throwServerError( $body, $httpStatusCode ) {
		$description = "The server did not send back a well-formed response. " . PHP_EOL . "Server Response: $body";

		throw new Errors\ServerError( $description, ErrorCode::SERVER_ERROR, $httpStatusCode );
	}

	protected function getRequestHeaders() {
		$uaHeader = array(
			'User-Agent' => $this->constructUa(),
		);
		
		$headers = array_merge( self::$headers, $uaHeader );

		return $headers;
	}

	protected function constructUa() {
		$ua = 'Razorpay/v1 PHPSDK/' . Api::VERSION . ' PHP/' . phpversion();

		$ua .= ' ' . $this->getAppDetailsUa();

		return $ua;
	}

	protected function getAppDetailsUa() {
		$appsDetails = Api::$appsDetails;

		$appsDetailsUa = '';

		foreach ( $appsDetails as $app ) {
			if ( ( isset( $app['title'] ) ) && ( is_string($app['title'] ) ) ) {
				$appUa = $app['title'];

				if ( ( isset($app['version'] ) ) and ( is_scalar( $app['version'] ) ) ) {
					$appUa .= '/' . $app['version'];
				}

				$appsDetailsUa .= $appUa . ' ';
			}
		}

		return $appsDetailsUa;
	}

	protected function verifyErrorFormat( $body, $httpStatusCode ) {
		if ( false === is_array( $body ) ) {
			$this->throwServerError( $body, $httpStatusCode );
		}

		if ( ( false === isset( $body['error'] ) ) || ( false === isset( $body['error']['code'] ) ) ) {
			$this->throwServerError( $body, $httpStatusCode );
		}

		$code = $body['error']['code'];

		if ( false === Errors\ErrorCode::exists( $code ) ) {
			$this->throwServerError( $body, $httpStatusCode );
		}
	}
}

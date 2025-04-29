<?php
// phpcs:ignoreFile
if ( ! defined( 'REQUESTS_SILENCE_PSR0_DEPRECATIONS' ) ) {
    define( 'REQUESTS_SILENCE_PSR0_DEPRECATIONS', true );
}

if ( class_exists( 'WpOrg\Requests\Autoload' ) === false ) {
	require_once __DIR__.'/libs/Requests-2.0.0/src/Autoload.php';
}

try {
	WpOrg\Requests\Autoload::register();

	if ( -1 === version_compare( Requests::VERSION, '1.6.0' ) ) {
		throw new Exception( 'Requests class found but did not match' );
	}
} catch ( \Exception $e ) {
	throw new Exception('Requests class found but did not match');
}

spl_autoload_register( function ( $class ) {
	$prefix = 'Razorpay\Api';

	$base_dir = __DIR__ . '/src/';

	$len = strlen($prefix);
	if ( 0 !== strncmp( $prefix, $class, $len ) ) {
		return;
	}

	$relative_class = substr($class, $len);
	$file           = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

	if ( file_exists( $file ) ) {
		require $file;
	}
});

<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package ThemePlate
 * @since   0.1.0
 */

$_test_suite = array_search( '--testsuite', $GLOBALS['argv'], true );

if ( false === $_test_suite || ! in_array( strtolower( $GLOBALS['argv'][ (int) $_test_suite + 1 ] ), array( 'default', 'integration' ), true ) ) {
	return;
}

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( '' === $_tests_dir || false === $_tests_dir ) {
	$_tests_dir = getcwd() . '/.cache/wordpress-tests-lib';
}

// Forward custom PHPUnit Polyfills configuration to PHPUnit bootstrap file.
$_phpunit_polyfills_path = getenv( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' );
if ( false !== $_phpunit_polyfills_path ) {
	define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $_phpunit_polyfills_path );
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
	$_work_dir = '.';

	if ( getcwd() !== dirname( __DIR__ ) ) {
		$_work_dir .= '/vendor';
	}

	echo sprintf( 'Could not find %s/includes/functions.php, have you run `%s/bin/themeplate setup` ?', $_tests_dir, $_work_dir ) . PHP_EOL; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	exit( 1 );
}

if ( ! defined( 'WP_TESTS_CONFIG_FILE_PATH' ) ) {
	define( 'WP_TESTS_CONFIG_FILE_PATH', getcwd() . '/.cache/wp-tests-config.php' );
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

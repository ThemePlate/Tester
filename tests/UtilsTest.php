<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

use ThemePlate\Tester\Utils;

class UtilsTest extends WP_UnitTestCase {

	protected $unliberated;


	protected function setUp(): void {

		$this->unliberated = new class() {
			private string $property_name = 1 . 'value';

			/* @phpstan-ignore-next-line unused method */
			private function method_name( int $arg ): bool {
				return $arg . 'value' === $this->property_name;
			}
		};

	}


	public function test_liberate_method() {

		$value = Utils::invoke_inaccessible_method( $this->unliberated, 'method_name', array( 1 ) );

		$this->assertIsBool( $value );
		$this->assertSame( true, $value );

	}


	public function test_liberate_property() {

		$value = Utils::get_inaccessible_property( $this->unliberated, 'property_name' );

		$this->assertIsString( $value );
		$this->assertSame( '1value', $value );

	}

}
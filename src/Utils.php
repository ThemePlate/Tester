<?php

/**
 * @package ThemePlate
 * @since   0.1.0
 */

namespace ThemePlate\Tester;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

class Utils {

	protected static function get_reflection( string $object_or_class, string $type, string $name ) {

		try {
			$reflector = new ReflectionClass( $object_or_class );

			$method = 'get' . ucfirst( $type );
			$wanted = $reflector->$method( $name );

			$wanted->setAccessible( true );
		} catch ( ReflectionException $exception ) {
			$wanted = null;
		}

		return $wanted;

	}

	public static function get_reflection_method( string $object_or_class, string $name ): ?ReflectionMethod {

		return self::get_reflection( $object_or_class, 'method', $name );

	}


	public static function get_reflection_property( string $object_or_class, string $name ): ?ReflectionProperty {

		return self::get_reflection( $object_or_class, 'property', $name );

	}


	/**
	 * @throws ReflectionException
	 */
	public static function invoke_inaccessible_method( object $instance, string $name, array $args = array() ) {

		$reflection = self::get_reflection_method( get_class( $instance ), $name );

		if ( ! $reflection instanceof ReflectionMethod ) {
			return null;
		}

		return $reflection->invokeArgs( $instance, $args );

	}


	public static function get_inaccessible_property( object $instance, string $name ) {

		$reflection = self::get_reflection_property( get_class( $instance ), $name );

		if ( ! $reflection instanceof ReflectionProperty ) {
			return null;
		}

		return $reflection->getValue( $instance );

	}


	public static function set_inaccessible_property( object $instance, string $name, $value ): void {

		$reflection = self::get_reflection_property( get_class( $instance ), $name );

		if ( ! $reflection instanceof ReflectionProperty ) {
			return;
		}

		$reflection->setValue( $instance, $value );

	}

}

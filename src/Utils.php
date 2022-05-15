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

	protected static function get_reflection( string $class, string $type, string $name ) {

		try {
			$reflector = new ReflectionClass( $class );

			$method = 'get' . ucfirst( $type );
			$wanted = $reflector->$method( $name );

			$wanted->setAccessible( true );
		} catch ( ReflectionException $exception ) {
			$wanted = null;
		}

		return $wanted;

	}

	public static function get_reflection_method( string $class, string $name ): ?ReflectionMethod {

		return self::get_reflection( $class, 'method', $name );

	}


	public static function get_reflection_property( string $class, string $name ): ?ReflectionProperty {

		return self::get_reflection( $class, 'property', $name );

	}


	public static function invoke_inaccessible_method( object $instance, string $name, array $args = array() ) {

		return self::get_reflection_method( get_class( $instance ), $name )->invokeArgs( $instance, $args );

	}


	public static function get_inaccessible_property( object $instance, string $name ) {

		return self::get_reflection_property( get_class( $instance ), $name )->getValue( $instance );

	}

}

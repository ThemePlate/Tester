# ThemePlate Tester

## Usage

### composer.json
```json
{
	"name": "my/package",
	"require": {
		"php": "^7.4|^8.0"
	},
	"require-dev": {
		"themeplate/tester": "*"
	},
	"autoload-dev": {
		"psr-4": {
			"Tests\\": "tests"
		}
	}
}
```

### SampleTest.php
```php
namespace Tests;

use ThemePlate\Tester\Utils;

class SampleTest extends WP_UnitTestCase {
	public function test_sample() {
		$instance = new Class();

		Utils::invoke_inaccessible_method( $instance, 'method_name', array( 'arg1', 'arg2' ) );

		$value = Utils::get_inaccessible_property( $instance, 'property_name' );

		Utils::set_inaccessible_property( $instance, 'wanted_property', $value );

		// Do actual assertions
	}
}
```

### After `composer install`, run `./vendor/bin/install-wp-tests`
- Analyse `./vendor/bin/phpstan analyse -c ./vendor/themeplate/tester/phpstan.neon ./tests`
- Lint `./vendor/bin/phpcs --standard="./vendor/themeplate/tester/phpcs.xml" ./tests`
- Fix `./vendor/bin/phpcbf --standard="./vendor/themeplate/tester/phpcs.xml" ./tests`
- Test `./vendor/bin/phpunit -c ./vendor/themeplate/tester/phpunit.xml ./tests`

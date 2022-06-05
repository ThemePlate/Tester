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

### After `composer install`, run `./vendor/bin/themeplate setup`
- Analyse `./vendor/bin/themeplate analyse`
- Lint `./vendor/bin/themeplate lint`
- Fix `./vendor/bin/themeplate fix`
- Test `./vendor/bin/themeplate test`

#### Dump the configs for customizations `./vendor/bin/themeplate dump`

#### Sample composer scripts
```json
...
    "scripts": {
        "analyse": "./vendor/bin/themeplate analyse",
        "lint": "./vendor/bin/themeplate lint",
        "fix": "./vendor/bin/themeplate fix",
        "test": "./vendor/bin/themeplate test",
        "test:unit": "./vendor/bin/themeplate test --type unit",
        "test:integration": "./vendor/bin/themeplate test --type integration"
    }
...
```

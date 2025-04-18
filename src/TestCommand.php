<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class TestCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	/** @var string */
	protected static $defaultName = 'test';

	/** @var string */
	protected static $defaultDescription = 'Run the tests';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->setName( self::$defaultName );
		$this->setDescription( self::$defaultDescription );
		// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->addArgument( 'path', InputArgument::OPTIONAL, 'Specify the test path', './tests' );
		$this->addArgument( 'extra', InputArgument::IS_ARRAY, 'To be passed to <info>phpunit</info>', array() );
		$this->addOption( 'type', null, InputOption::VALUE_REQUIRED, 'Filter which testsuite to run', 'default' );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$base   = DIRECTORY_SEPARATOR . 'phpunit.xml';
		$config = dirname( __DIR__ ) . $base;

		if ( file_exists( getcwd() . $base ) ) {
			$config = getcwd() . $base;
		}

		$args = array( './vendor/bin/phpunit' );
		$path = $input->getArgument( 'path' );
		$type = $input->getOption( 'type' );

		$args[] = '--testsuite';
		$args[] = $type;

		switch ( $type ) {
			case 'default':
			default:
				$args[] = $path;
				break;
			case 'unit':
				$args[] = $path . '/Unit';
				break;
			case 'integration':
				$args[] = $path . '/Integration';
				break;
		}

		$args[] = '--config';
		$args[] = $config;

		array_push( $args, ...$input->getArgument( 'extra' ) );

		return ( new Process( $args ) )
			->setPty( Process::isPtySupported() )
			->run(
				function ( $type, $buffer ) use ( $output ): void {
					$output->write( $buffer );
				}
			);

	}

}

<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class SetupCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	/** @var string */
	protected static $defaultName = 'setup';

	/** @var string */
	protected static $defaultDescription = 'Setup the tests';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->setName( self::$defaultName );
		$this->setDescription( self::$defaultDescription );
		// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->addOption( 'db-name', null, InputOption::VALUE_OPTIONAL, 'Name of the database', 'local' );
		$this->addOption( 'db-user', null, InputOption::VALUE_OPTIONAL, 'DB Authentication: Username', 'root' );
		$this->addOption( 'db-pass', null, InputOption::VALUE_OPTIONAL, 'DB Authentication: Password', 'root' );
		$this->addOption( 'db-host', null, InputOption::VALUE_OPTIONAL, 'Hostname to connect to DB', 'localhost' );
		$this->addOption( 'wp-version', null, InputOption::VALUE_OPTIONAL, 'WordPress version to install', 'latest' );
		$this->addOption( 'db-creation', null, InputOption::VALUE_OPTIONAL, 'Database creation [true|false|force]', 'true' );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$args = array(
			'sh',
			dirname( __DIR__ ) . '/bin/install-wp-tests.sh',
			$input->getOption( 'db-name' ),
			$input->getOption( 'db-user' ),
			$input->getOption( 'db-pass' ),
			$input->getOption( 'db-host' ),
			$input->getOption( 'wp-version' ),
			$input->getOption( 'db-creation' ),
		);

		return ( new Process( $args ) )
			->setPty( Process::isPtySupported() )
			->run(
				function ( $type, $buffer ) use ( $output ): void {
					$output->write( $buffer );
				}
			);

	}

}

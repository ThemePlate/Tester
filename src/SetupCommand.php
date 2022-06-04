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

class SetupCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	protected static $defaultName        = 'setup';
	protected static $defaultDescription = 'Setup the tests';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		$this->addArgument( 'db-name', InputArgument::REQUIRED, 'Name of the database' );
		$this->addArgument( 'db-user', InputArgument::REQUIRED, 'DB Authentication: Username' );
		$this->addArgument( 'db-pass', InputArgument::REQUIRED, 'DB Authentication: Password' );
		$this->addArgument( 'db-host', InputArgument::REQUIRED, 'Hostname to connect to DB' );
		$this->addArgument( 'wp-version', InputArgument::OPTIONAL, 'WordPress version to install', 'latest' );
		$this->addArgument( 'skip-database-creation', InputArgument::OPTIONAL, 'Skip database creation', false );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$args = array(
			'sh',
			dirname( __FILE__, 2 ) . '/bin/install-wp-tests',
			$input->getArgument( 'db-name' ),
			$input->getArgument( 'db-user' ),
			$input->getArgument( 'db-pass' ),
			$input->getArgument( 'db-host' ),
			$input->getArgument( 'wp-version' ),
			$input->getArgument( 'skip-database-creation' ),
		);

		$process = new Process( $args );

		$process->run();

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $process->getErrorOutput();
		echo $process->getOutput();
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped

		return Command::SUCCESS;

	}

}

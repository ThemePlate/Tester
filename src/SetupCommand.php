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

		$this->addArgument( 'db-name', InputArgument::OPTIONAL, 'Name of the database', 'local' );
		$this->addArgument( 'db-user', InputArgument::OPTIONAL, 'DB Authentication: Username', 'root' );
		$this->addArgument( 'db-pass', InputArgument::OPTIONAL, 'DB Authentication: Password', 'root' );
		$this->addArgument( 'db-host', InputArgument::OPTIONAL, 'Hostname to connect to DB', 'localhost' );
		$this->addArgument( 'wp-version', InputArgument::OPTIONAL, 'WordPress version to install', 'latest' );
		$this->addArgument( 'skip-database-creation', InputArgument::OPTIONAL, 'Skip database creation', false );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$args = array(
			'sh',
			dirname( __FILE__, 2 ) . '/bin/install-wp-tests.sh',
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

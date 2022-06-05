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

		$this->addOption( 'db-name', null, InputOption::VALUE_OPTIONAL, 'Name of the database', 'local' );
		$this->addOption( 'db-user', null, InputOption::VALUE_OPTIONAL, 'DB Authentication: Username', 'root' );
		$this->addOption( 'db-pass', null, InputOption::VALUE_OPTIONAL, 'DB Authentication: Password', 'root' );
		$this->addOption( 'db-host', null, InputOption::VALUE_OPTIONAL, 'Hostname to connect to DB', 'localhost' );
		$this->addOption( 'wp-version', null, InputOption::VALUE_OPTIONAL, 'WordPress version to install', 'latest' );
		$this->addOption( 'skip-database-creation', null, InputOption::VALUE_OPTIONAL, 'Skip database creation', false );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$args = array(
			'sh',
			dirname( __FILE__, 2 ) . '/bin/install-wp-tests.sh',
			$input->getOption( 'db-name' ),
			$input->getOption( 'db-user' ),
			$input->getOption( 'db-pass' ),
			$input->getOption( 'db-host' ),
			$input->getOption( 'wp-version' ),
			$input->getOption( 'skip-database-creation' ),
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

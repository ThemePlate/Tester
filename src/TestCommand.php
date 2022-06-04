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
	protected static $defaultName        = 'test';
	protected static $defaultDescription = 'Run the tests';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		$this->addArgument( 'path', InputArgument::OPTIONAL, 'Specify the test path', './tests' );
		$this->addOption( 'type', null, InputOption::VALUE_REQUIRED, 'Filter which testsuite to run', 'default' );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

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
		$args[] = dirname( __FILE__, 2 ) . '/phpunit.xml';

		$process = new Process( $args );

		$process->run();

		// phpcs:disable WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $process->getErrorOutput();
		echo $process->getOutput();
		// phpcs:enable WordPress.Security.EscapeOutput.OutputNotEscaped

		return Command::SUCCESS;

	}

}

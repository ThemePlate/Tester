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

class AnalyseCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	protected static $defaultName        = 'analyse';
	protected static $defaultDescription = 'Analyse the codes';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		$this->addArgument( 'path', InputArgument::OPTIONAL, 'Specify the test path', './src' );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$args = array(
			'./vendor/bin/phpstan',
			'analyse',
			'--configuration',
			dirname( __FILE__, 2 ) . '/phpstan.neon',
			$input->getArgument( 'path' ),
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

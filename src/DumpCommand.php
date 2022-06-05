<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Process;

class DumpCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	protected static $defaultName        = 'dump';
	protected static $defaultDescription = 'Dump the configs';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		$this->addArgument( 'path', InputArgument::OPTIONAL, 'Specify the dump path', './' );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$files = array(
			'phpcs.xml',
			'phpstan.neon',
			'phpunit.xml',
		);

		$helper = $this->getHelper( 'question' );
		$source = dirname( __FILE__, 2 ) . DIRECTORY_SEPARATOR;

		foreach ( $files as $file ) {
			if ( file_exists( $input->getArgument( 'path' ) . $file ) ) {
				$question = new ConfirmationQuestion( 'Overwrite "' . $file . '"? ', false );

				if ( ! $helper->ask( $input, $output, $question ) ) {
					continue;
				}
			}

			copy( $source . $file, $input->getArgument( 'path' ) . $file );
			echo 'Copied "' . $file . "\"\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		return Command::SUCCESS;

	}

}

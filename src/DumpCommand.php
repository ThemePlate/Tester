<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class DumpCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	protected static $defaultName        = 'dump';
	protected static $defaultDescription = 'Dump the configs';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->setName( self::$defaultName );
		$this->setDescription( self::$defaultDescription );
		// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->addArgument( 'path', InputArgument::OPTIONAL, 'Specify the dump path', '.' );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$files = array(
			'phpcs.xml',
			'phpstan.neon',
			'phpunit.xml',
			'tests/bootstrap.php',
		);

		/** @var QuestionHelper $helper */
		$helper = $this->getHelper( 'question' );
		$source = dirname( __DIR__ ) . DIRECTORY_SEPARATOR;

		$destination = rtrim( $input->getArgument( 'path' ), '/\\' ) . DIRECTORY_SEPARATOR;

		if ( ! is_dir( $destination ) ) {
			mkdir( $destination ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_mkdir
		}

		if ( ! is_dir( $destination . 'tests' ) ) {
			mkdir( $destination . 'tests' ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_mkdir
		}

		foreach ( $files as $file ) {
			if ( file_exists( $destination . $file ) ) {
				$question = new ConfirmationQuestion( 'Overwrite "' . $file . '"? ', false );

				if ( ! $helper->ask( $input, $output, $question ) ) {
					$output->writeln( 'Skipped "' . $file . '"' );
					continue;
				}
			}

			copy( $source . $file, $destination . $file );
			$output->writeln( 'Copied "' . $file . '"' );
		}

		return Command::SUCCESS;

	}

}

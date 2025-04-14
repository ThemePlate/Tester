<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\Tester;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class AnalyseCommand extends Command {

	// phpcs:disable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase
	/** @var string */
	protected static $defaultName = 'analyse';

	/** @var string */
	protected static $defaultDescription = 'Analyse the codes';
	// phpcs:enable WordPress.NamingConventions.ValidVariableName.PropertyNotSnakeCase


	protected function configure(): void {

		// phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->setName( self::$defaultName );
		$this->setDescription( self::$defaultDescription );
		// phpcs:enable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		$this->addArgument( 'path', InputArgument::OPTIONAL, 'Specify the analyse path', '.' );
		$this->addArgument( 'extra', InputArgument::IS_ARRAY, 'To be passed to <info>phpstan</info>', array() );

	}


	protected function execute( InputInterface $input, OutputInterface $output ): int {

		$base   = DIRECTORY_SEPARATOR . 'phpstan.neon';
		$config = dirname( __DIR__ ) . $base;

		if ( file_exists( getcwd() . $base ) ) {
			$config = getcwd() . $base;
		}

		$args = array(
			'./vendor/bin/phpstan',
			'analyse',
			'--configuration',
			$config,
			$input->getArgument( 'path' ),
			...$input->getArgument( 'extra' ),
		);

		$process = new Process( $args );

		$process->setTty( Process::isTtySupported() )->run(
			function ( $type, $buffer ) use ( $output ): void {
				$output->write( $buffer );
			}
		);

		return $process->isSuccessful() ? Command::SUCCESS : Command::FAILURE;

	}

}

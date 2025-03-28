<?php

/**
 * @package ThemePlate
 */

namespace ThemePlate\Tester\Tests\Commands;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use ThemePlate\Tester\DumpCommand;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DumpCommandTest extends TestCase {
	public function testExecute(): void {
		$command = new DumpCommand();
		$tester  = new CommandTester( $command );

		( new Application() )->add( $command );

		$path = './tester';

		for ( $i = 1; $i <= 2; $i++ ) {
			ob_start();
			$tester->execute( compact( 'path' ) );
			$this->assertIsString( ob_get_clean() );
			$tester->assertCommandIsSuccessful();
		}

		$files = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator(
				$path,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
			RecursiveIteratorIterator::CHILD_FIRST
		);

		foreach ( $files as $fileinfo ) {
			$command = ( $fileinfo->isDir() ? 'rmdir' : 'unlink' );

			$command( $fileinfo->getRealPath() );
		}

		rmdir( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rmdir
	}
}

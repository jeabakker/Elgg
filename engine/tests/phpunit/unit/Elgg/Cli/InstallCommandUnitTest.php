<?php

namespace Elgg\Cli;

use Elgg\UnitTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group Cli
 */
class InstallCommandUnitTest extends UnitTestCase {

	public function testExecute() {

		$this->markTestSkipped('Can\'t test the installer yet');

		$application = new Application();
		$application->add(new InstallCommand());

		$command = $application->find('install');
		$commandTester = new CommandTester($command);
		$commandTester->execute([
			'command' => $command->getName(),
			//'--quiet' => true,
		]);

		dump($commandTester->getDisplay());
	}
}

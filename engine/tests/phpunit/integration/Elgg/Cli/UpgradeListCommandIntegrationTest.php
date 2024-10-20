<?php

namespace Elgg\Cli;

use Elgg\IntegrationTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @group Cli
 */
class UpgradeListCommandIntegrationTest extends IntegrationTestCase {

	public function up() {
		self::createApplication([
			'isolate'=> true,
		]);
	}

	public function testExecuteWithoutOptions() {
		$application = new Application();
		$application->add(new UpgradeListCommand());

		$command = $application->find('upgrade:list');
		$commandTester = new CommandTester($command);
		$commandTester->execute([
			'command' => $command->getName(),
		]);

		$this->assertNotEmpty($commandTester->getDisplay());
	}
}

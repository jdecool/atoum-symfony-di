<?php

namespace jdecool\atoum\symfonyDependencyInjection;

use
	mageekguy\atoum,
	mageekguy\atoum\observable,
	mageekguy\atoum\runner,
	mageekguy\atoum\test
;

class extension implements atoum\extension
{
	public function __construct(atoum\configurator $configurator = null)
	{
		if ($configurator)
		{
			$script = $configurator->getScript();

			$handler = function($script, $argument, $values) {
				$script->getRunner()->addTestsFromDirectory(dirname(__DIR__) . '/tests/units/classes');
			};

			$script
				->addArgumentHandler($handler, array('--test-ext'))
				->addArgumentHandler($handler, array('--test-it'))
			;
		}
	}

	public function setRunner(runner $runner)
	{
		return $this;
	}

	public function setTest(test $test)
	{
		$asserter = null;

		$test->getAssertionManager()
			->setHandler(
				'containerBuilder',
				function($object) use ($test, & $asserter) {
					if ($asserter === null)
					{
						$asserter = new atoum\symfonyDependencyInjection\asserters\containerBuilder($test->getAsserterGenerator());
					}

					return $asserter->setWith($object);
				}
			)
			->setHandler(
				'serviceDefinition',
				function($object) use ($test, & $asserter) {
					if ($asserter === null)
					{
						$asserter = new atoum\symfonyDependencyInjection\asserters\serviceDefinition($test->getAsserterGenerator());
					}

					return $asserter->setWith($object);
				}
			)
		;

		return $this;
	}

	public function handleEvent($event, observable $observable) {}
}

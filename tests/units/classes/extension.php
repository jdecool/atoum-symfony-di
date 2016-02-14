<?php

namespace jdecool\atoum\symfonyDependencyInjection\tests\units;

use
	mageekguy\atoum,
	jdecool\atoum\symfonyDependencyInjection\extension as testedClass,
	Symfony\Component\DependencyInjection\ContainerBuilder
;

class extension extends atoum\test
{
	public function testClass()
	{
		$this
			->testedClass
				->hasInterface('mageekguy\atoum\extension')
		;
	}

	public function test__construct()
	{
		$this
			->if($script = new atoum\scripts\runner(uniqid()))
			->and($script->setArgumentsParser($parser = new \mock\mageekguy\atoum\script\arguments\parser()))
			->and($configurator = new \mock\mageekguy\atoum\configurator($script))
			->then
				->object($extension = new testedClass())
			->if($this->resetMock($parser))
			->if($extension = new testedClass($configurator))
			->then
				->mock($parser)
					->call('addHandler')->twice()
		;
	}

	public function testSetRunner()
	{
		$this
			->if($extension = new testedClass())
			->and($runner = new atoum\runner())
			->then
				->object($extension->setRunner($runner))->isIdenticalTo($extension)
		;
	}

	public function testSetTest()
	{
		$this
			->given(
				$container = new ContainerBuilder(),
				$manager = new \mock\mageekguy\atoum\test\assertion\manager(),
				$test = new \mock\mageekguy\atoum\test(),
				$test->setAssertionManager($manager)
			)
			->if($extension = new testedClass())
			->then
				->object($extension->setTest($test))
					->isIdenticalTo($extension)
				->mock($manager)
					->call('setHandler')
						->withArguments('containerBuilder')->once()
						->withArguments('serviceDefinition')->once()
		;
	}
}

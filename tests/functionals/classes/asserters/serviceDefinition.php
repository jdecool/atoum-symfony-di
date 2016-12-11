<?php

namespace jdecool\atoum\symfonyDependencyInjection\asserters\tests\functionals;

use
	mageekguy\atoum,
	Symfony\Component\DependencyInjection
;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class serviceDefinition extends atoum\test
{
	protected function initializeContainer()
	{
		$container = new DependencyInjection\ContainerBuilder();
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/_data'));
		$loader->load('example.xml');

		return $container;
	}

	public function testIsInstanceOf()
	{
		$this
			->given($container = $this->initializeContainer())
			->serviceDefinition($container->getDefinition('serviceid'))
				->isInstanceOf('ArrayObject')
		;
	}

	public function testIsNotInstanceOf()
	{
		$this
			->given($container = $this->initializeContainer())
			->serviceDefinition($container->getDefinition('serviceid'))
				->isNotInstanceOf('SplFileObject')
		;
	}

	public function testHasArgument()
	{
		$this
			->given($container = $this->initializeContainer())
			->serviceDefinition($container->getDefinition('serviceid'))
				->hasArgument(0)
		;
	}

	public function testHasTag()
	{
		$this
			->given($container = $this->initializeContainer())
			->serviceDefinition($container->getDefinition('serviceid'))
				->hasTag('myCustomTag')
		;
	}

	public function testHasMethodCall()
	{
		$this
			->given($container = $this->initializeContainer())
			->serviceDefinition($container->getDefinition('serviceid'))
				->hasMethodCall('append')
		;
	}

	public function getTestNamespace()
	{
		return '#(?:^|\\\)tests?\\\functionals?\\\#i';
	}
}

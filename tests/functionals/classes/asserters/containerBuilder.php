<?php

namespace jdecool\atoum\symfonyDependencyInjection\asserters\tests\functionals;

use
	mageekguy\atoum,
	Symfony\Component\DependencyInjection
;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class containerBuilder extends atoum\test
{
	protected function initializeContainer()
	{
		$container = new DependencyInjection\ContainerBuilder();
		$loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/_data'));
		$loader->load('example.xml');

		return $container;
	}

	public function testHasService()
	{
		$this
			->containerBuilder($this->initializeContainer())
				->hasService('serviceid')
		;
	}

	public function testHasNotService()
	{
		$this
			->containerBuilder($this->initializeContainer())
				->hasNotService('service_id')
		;
	}

	public function testHasAlias()
	{
		$this
			->containerBuilder($this->initializeContainer())
				->hasAlias('myAwesomeAlias')
		;
	}

	public function testSyntheticService()
	{
		$this
			->containerBuilder($this->initializeContainer())
				->hasSyntheticService('app.synthetic_service')
		;
	}

	public function testHasParameter()
	{
		$this
			->containerBuilder($this->initializeContainer())
				->hasParameter('mailer.transport')
		;
	}

	public function testHasNotParameter()
	{
		$this
			->containerBuilder($this->initializeContainer())
				->hasNotParameter('mailer_transport')
		;
	}

	public function getTestNamespace()
	{
		return '#(?:^|\\\)tests?\\\functionals?\\\#i';
	}
}

<?php

namespace jdecool\atoum\symfonyDependencyInjection\tests\units\asserters;

use
	mageekguy\atoum,
	Symfony\Component\DependencyInjection
;

class containerBuilder extends atoum\test
{
	public function testClass()
	{
		$this
			->testedClass
				->isSubClassOf('mageekguy\atoum\asserters\variable')
		;
	}

	public function testSetWidth()
	{
		$this
			->if($asserter = $this->newTestedInstance())
			->then
				->exception(function() use ($asserter) {
					$asserter->setWith(new \stdClass);
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage(sprintf('stdClass is not an instance of Symfony\Component\DependencyInjection\ContainerBuilder', $asserter))

				->object($asserter->setWith($value = new DependencyInjection\ContainerBuilder()))->isIdenticalTo($asserter)
				->object($asserter->getValue())->isIdenticalTo($value)
		;
	}

	public function testHasService()
	{
		$this
			->given(
				$container = new DependencyInjection\ContainerBuilder(),
				$container->register('foo', 'stdClass')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($container))
			->then
				->object($asserter->hasService('foo'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasService('bar');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Service "bar" not exists in container')
		;
	}

	public function testHasAlias()
	{
		$this
			->given(
				$container = new DependencyInjection\ContainerBuilder(),
				$container->register('foo', 'stdClass'),
				$container->setAlias('fooAlias', 'foo')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($container))
			->then
				->object($asserter->hasAlias('fooAlias'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasAlias('foo');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Alias "foo" not exists in container')
		;
	}

	public function testHasSyntheticService()
	{
		$this
			->given(
				$definition = new DependencyInjection\Definition('stdClass'),
				$definition->setSynthetic(false),
				$syntheticDef = new DependencyInjection\Definition('stdClass'),
				$syntheticDef->setSynthetic(true),
				$container = new DependencyInjection\ContainerBuilder(),
				$container->addDefinitions([
					'service' => $definition,
					'serviceSynthetic' => $syntheticDef,
				])
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($container))
			->then
				->object($asserter->hasSyntheticService('serviceSynthetic'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasSyntheticService('service');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
			->hasMessage('Service "service" is not synthetic')
		;
	}

	public function testHasNotService()
	{
		$this
			->given(
				$container = new DependencyInjection\ContainerBuilder(),
				$container->register('foo', 'stdClass')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($container))
			->then
				->object($asserter->hasNotService('bar'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasNotService('foo');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Service "foo" exists in container')
		;
	}

	public function testHasParameter()
	{
		$this
			->given(
				$container = new DependencyInjection\ContainerBuilder(),
				$container->setParameter('foo', 'bar')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($container))
			->then
				->object($asserter->hasParameter('foo'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasParameter('bar');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Parameter "bar" not exists in container')
		;
	}

	public function testHasNotParameter()
	{
		$this
			->given(
				$container = new DependencyInjection\ContainerBuilder(),
				$container->setParameter('foo', 'bar')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($container))
			->then
				->object($asserter->hasNotParameter('bar'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasNotParameter('foo');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Parameter "foo" exists in container')
		;
	}
}

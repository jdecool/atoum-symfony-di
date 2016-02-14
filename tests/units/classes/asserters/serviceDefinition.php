<?php

namespace jdecool\atoum\symfonyDependencyInjection\tests\units\asserters;

use
	mageekguy\atoum,
	Symfony\Component\DependencyInjection
;

class serviceDefinition extends atoum\test
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
					->hasMessage(sprintf('stdClass is not an instance of Symfony\Component\DependencyInjection\Definition', $asserter))

				->object($asserter->setWith($value = new DependencyInjection\Definition()))->isIdenticalTo($asserter)
				->object($asserter->getValue())->isIdenticalTo($value)
		;
	}

	public function testIsInstanceOf()
	{
		$this
			->given($definition = new DependencyInjection\Definition('stdClass'))
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($definition))
			->then
				->object($asserter->isInstanceOf('stdClass'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->isInstanceOf('foo');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('"stdClass" is not an instance of "foo"')
		;
	}

	public function testIsNotInstanceOf()
	{
		$this
			->given($definition = new DependencyInjection\Definition('stdClass'))
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($definition))
			->then
				->object($asserter->isNotInstanceOf('foo'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->isNotInstanceOf('stdClass');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('"stdClass" is an instance of "stdClass"')
		;
	}

	public function testHasTag()
	{
		$this
			->given(
				$definition = new DependencyInjection\Definition('stdClass'),
				$definition->addTag('myTag')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($definition))
			->then
				->object($asserter->hasTag('myTag'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasTag('foo');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Tag "foo" not exists')
		;
	}

	public function testHasArgument()
	{
		$this
			->given(
				$definition = new DependencyInjection\Definition('stdClass'),
				$definition->setArguments([0, 1])
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($definition))
			->then
				->object($asserter->hasArgument(0))->isIdenticalTo($asserter)
				->object($asserter->hasArgument(1))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasArgument(2);
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('The definition has no argument with index "2"')
		;
	}

	public function testHasMethodCall()
	{
		$this
			->given(
				$definition = new DependencyInjection\Definition('stdClass'),
				$definition->addMethodCall('foo')
			)
			->if($asserter = $this->newTestedInstance())
			->and($asserter->setWith($definition))
			->then
				->object($asserter->hasMethodCall('foo'))->isIdenticalTo($asserter)

				->exception(function() use ($asserter) {
					$asserter->hasMethodCall('bar');
				})
					->isInstanceOf('mageekguy\atoum\asserter\exception')
					->hasMessage('Method call "bar" not match')
		;
	}
}

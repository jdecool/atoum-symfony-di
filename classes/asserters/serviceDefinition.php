<?php

namespace jdecool\atoum\symfonyDependencyInjection\asserters;

use
	mageekguy\atoum\asserters,
	mageekguy\atoum\exceptions,
	Symfony\Component\DependencyInjection
;

class serviceDefinition extends asserters\variable
{
	public function isInstanceOf($value, $failMessage = null)
	{
		$definition = $this->valueIsSet()->value;
		self::check($definition, __FUNCTION__);

		if ($definition->getClass() == $value)
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('"%s" is not an instance of "%s"', $definition->getClass(), is_string($value) === true ? $value : $this->getTypeOf($value)));
		}

		return $this;
	}

	public function isNotInstanceOf($value, $failMessage = null)
	{
		$definition = $this->valueIsSet()->value;
		self::check($definition, __FUNCTION__);

		if ($definition->getClass() != $value)
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('"%s" is an instance of "%s"', $definition->getClass(), is_string($value) === true ? $value : $this->getTypeOf($value)));
		}

		return $this;
	}

	public function hasArgument($index, $failMessage = null)
	{
		$definition = $this->valueIsSet()->value;
		self::check($definition, __FUNCTION__);

		try
		{
			$definition->getArgument($index);

			$this->pass();
		}
		catch (\Exception $e)
		{
			$this->fail($failMessage ?: $this->_('The definition has no argument with index "%d"', $index));
		}

		return $this;
	}

	public function hasTag($name, $failMessage = null)
	{
		$definition = $this->valueIsSet()->value;
		self::check($definition, __FUNCTION__);

		foreach ($definition->getTags() as $tagName => $tagAttributes)
		{
			if ($tagName === $name)
			{
				$this->pass();

				return $this;
			}
		}

		$this->fail($failMessage ?: $this->_('Tag "%s" not exists', is_string($name) === true ? $name : $this->getTypeOf($name)));

		return $this;
	}

	public function hasMethodCall($methodName, $failMessage = null)
	{
		$definition = $this->valueIsSet()->value;
		self::check($definition, __FUNCTION__);

		foreach ($definition->getMethodCalls() as $methodCall)
		{
			list($method, $arguments) = $methodCall;

			if ($method === $methodName)
			{
				$this->pass();

				return $this;
			}
		}

		$this->fail($failMessage ?: $this->_('Method call "%s" not match', is_string($methodName) === true ? $methodName : $this->getTypeOf($methodName)));

		return $this;
	}

	public function setWith($value, $checkType = true)
	{
		parent::setWith($value, $checkType);

		if ($checkType === true)
		{
			if ($this->value instanceof DependencyInjection\Definition)
			{
				$this->pass();
			}
			else
			{
				$this->fail($this->_('%s is not an instance of Symfony\Component\DependencyInjection\Definition', get_class($this->value)));
			}
		}

		return $this;
	}

	protected function check($value, $method)
	{
		if (!($value instanceof DependencyInjection\Definition))
		{
			throw new exceptions\logic('Argument of ' . __CLASS__ . '::' . $method . '() must be a class instance');
		}

		return $this;
	}
}

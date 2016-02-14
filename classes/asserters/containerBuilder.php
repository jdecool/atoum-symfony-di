<?php

namespace jdecool\atoum\symfonyDependencyInjection\asserters;

use
	mageekguy\atoum\asserters,
	Symfony\Component\DependencyInjection
;

class containerBuilder extends asserters\variable
{
	public function hasService($serviceId, $failMessage = null)
	{
		if ($this->valueIsSet()->value->has($serviceId))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('Service "%s" not exists in container', is_string($serviceId) === true ? $serviceId : $this->getTypeOf($serviceId)));
		}

		return $this;
	}

	public function hasAlias($aliasId, $failMessage = null)
	{
		if ($this->valueIsSet()->value->hasAlias($aliasId))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('Alias "%s" not exists in container', is_string($aliasId) === true ? $aliasId : $this->getTypeOf($aliasId)));
		}

		return $this;
	}

	public function hasSyntheticService($serviceId, $failMessage = null)
	{
		if ($this->valueIsSet()->value->hasDefinition($serviceId) || $this->valueIsSet()->value->hasAlias($serviceId))
		{
			$definition = $this->valueIsSet()->value->findDefinition($serviceId);
			if ($definition->isSynthetic())
			{
				$this->pass();
			}
			else
			{
				$this->fail($failMessage ?: $this->_('Service "%s" is not synthetic', is_string($serviceId) === true ? $serviceId : $this->getTypeOf($serviceId)));
			}
		}
		else
		{
			$this->fail($failMessage ?: $this->_('The container builder has no service "%s"', is_string($serviceId) === true ? $serviceId : $this->getTypeOf($serviceId)));
		}

		return $this;
	}

	public function hasNotService($serviceId, $failMessage = null)
	{
		if (!$this->valueIsSet()->value->has($serviceId))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('Service "%s" exists in container', is_string($serviceId) === true ? $serviceId : $this->getTypeOf($serviceId)));
		}

		return $this;
	}

	public function hasParameter($parameterName, $failMessage = null)
	{
		if ($this->valueIsSet()->value->hasParameter($parameterName))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('Parameter "%s" not exists in container', is_string($parameterName) === true ? $parameterName : $this->getTypeOf($parameterName)));
		}

		return $this;
	}

	public function hasNotParameter($parameterName, $failMessage = null)
	{
		if (!$this->valueIsSet()->value->hasParameter($parameterName))
		{
			$this->pass();
		}
		else
		{
			$this->fail($failMessage ?: $this->_('Parameter "%s" exists in container', is_string($parameterName) === true ? $parameterName : $this->getTypeOf($parameterName)));
		}

		return $this;
	}

	public function setWith($value, $checkType = true)
	{
		parent::setWith($value, $checkType);

		if ($checkType === true)
		{
			if ($this->value instanceof DependencyInjection\ContainerBuilder)
			{
				$this->pass();
			}
			else
			{
				$this->fail($this->_('%s is not an instance of Symfony\Component\DependencyInjection\ContainerBuilder', get_class($this->value)));
			}
		}

		return $this;
	}
}

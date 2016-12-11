# AtoumSymfonyDI extension

[![Build Status](https://travis-ci.org/jdecool/atoum-symfony-di.svg?branch=master)](https://travis-ci.org/jdecool/atoum-symfony-di)

This extension is inspired by [SymfonyDependencyInjectionTest](https://github.com/matthiasnoback/SymfonyDependencyInjectionTest),
and used for simplify testing of Symfony DI.

## Example

```php
namespace Vendor\MyProjectBundle\DependencyInjection\Tests\Units;

use atoum;
use Vendor\MyProjectBundle\DependencyInjection\VendorMyBundleExtension as TestedClass;
use Symfony\Component\DependencyInjection;

class VendorMyBundleExtension extends atoum
{
    public function testLoad()
    {
        $this
            ->given(
                $container = new DependencyInjection\ContainerBuilder(),
                $testedClass = new TestedClass(),
                $testedClass->load([], $container)
            )
            ->then
                ->containerBuilder($container)
                    ->hasService('myServiceName')
                    ->hasParameter('myParameterName')
        ;
    }
}
```

## Install it

Install extension using [composer](https://getcomposer.org):

```
composer require --dev jdecool/atoum-symfony-di-extension
```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use jdecool\atoum\symfonyDependencyInjection;

$runner->addExtension(new symfonyDependencyInjection\extension($script));
```

## Asserters

This extension adds two new asserters : `containerBuilder` and `serviceDefinition`.

In the following examples we will assume we have a container definition like this one, available in a `$container` variable:

```xml
<parameters>
    <parameter key="mailer.transport">sendmail</parameter>
</parameters>

<services>
    <service id="myAwesomeAlias" alias="serviceid" />

    <service id="serviceid" class="ArrayObject" >
        <argument type="collection">
            <argument type="service"><service class="stdClass" /></argument>
        </argument>
        <call method="append">
            <argument type="service"><service class="stdClass" /></argument>
        </call>
        <tag name="myCustomTag" />
    </service>

    <service id="app.synthetic_service" synthetic="true" />
</services>
```

### containerBuilder

On the `containerBuilder` asserter, all assertions from the [variable](http://docs.atoum.org/en/latest/asserters.html#variable) asserter are available.

#### hasService

`hasService` checks if a service is present in the container.

```php
$this
    ->containerBuilder($container)
        ->hasService('serviceId') // passes
        ->hasService('service_id') // fails
;
```

#### hasAlias

`hasAlias` checks if an alias is present in the container.

```
$this
    ->containerBuilder($container)
        ->hasAlias('myAwesomeAlias') // passes
        ->hasAlias('anUnexistingAlias') // fails
;
```

#### hasSyntheticService

`hasSyntheticService` checks if a service is present in the container and is [synthetic](http://symfony.com/doc/current/service_container/synthetic_services.html).

```php
$this
    ->containerBuilder($container)
        ->hasSyntheticService('app.synthetic_service') // passes
        ->hasService('app.synthetic_service') // fails
        ->hasSyntheticService('app_synthetic_service') // fails
;
```

#### hasNotService

`hasNotService` checks if a service is not present in the container.

```php
$this
    ->containerBuilder($container)
        ->hasService('service_id') // passes
        ->hasService('serviceId') // fails
;
```

#### hasParameter

`hasParameter` checks if a parameter is present in the container.

```php
$this
    ->containerBuilder($container)
        ->hasParameter('mailer.transport') // passes
        ->hasParameter('mailer_transport') // fails
;
```

#### hasNotParameter

`hasNotParameter` checks if a parameter is not present in the container.

```php
$this
    ->containerBuilder($container)
        ->hasNotParameter('mailer_transport') // passes
        ->hasNotParameter('mailer.transport') // fails
;
```

### serviceDefinition

On the `serviceDefinition` asserter, all assertions from the [variable](http://docs.atoum.org/en/latest/asserters.html#variable) asserter are available.

#### isInstanceOf

`isInstanceOf` checks if the defined service class is the same as tested.

Warning : this will not check if the class inherits from another one.

```
$this
    ->serviceDefinition($container->getDefinition('serviceid'))
        ->isInstanceOf('ArrayObject') // passes
        ->isInstanceOf('SplFileObject') // fails
;
```

#### isNotInstanceOf

`isInstanceOf` checks if the defined service class is not the same as tested.

Warning : this will not check if the class inherits from another one.

```
$this
    ->serviceDefinition($container->getDefinition('serviceid'))
        ->isNotInstanceOf('SplFileObject') // passes
        ->isNotInstanceOf('ArrayObject') // fails 
;
```

#### hasArgument

`hasArgument` checks if the service definition has an argument in the index passed has parameter.

```
$this
    ->serviceDefinition($container->getDefinition('serviceid'))
        ->hasArgument(0)
;
```

#### hasTag

`hasTag` checks if the service definition has a given [tag](http://symfony.com/doc/current/service_container/tags.html).

```
$this
    ->serviceDefinition($container->getDefinition('serviceid'))
        ->hasTag('myCustomTag')
;
```

#### hasMethodCall

`hasMethodCall` checks if a service definition it a method call defined on the method name passed as parameter.

```
$this
    ->serviceDefinition($container->getDefinition('serviceid'))
        ->hasTag('myCustomTag')
;
```

## Links

* [atoum](http://atoum.org)
* [atoum's documentation](http://docs.atoum.org)
* [Symfony DependencyInjection Component documentation](http://symfony.com/doc/current/components/dependency_injection.html)

## License

This extension is released under the MIT License. See the bundled [LICENSE](LICENSE) file for details.

![atoum](http://atoum.org/images/logo/atoum.png)

# AtoumSymfonyDI extension

[![Build Status](https://travis-ci.org/jdecool/atoum-symfony-di.svg?branch=master)](https://travis-ci.org/jdecool/atoum-symfony-di)

This extension is inspired by [SymfonyDependencyInjectionTest](https://github.com/matthiasnoback/SymfonyDependencyInjectionTest),
and used for simplify testing of Symfony DI.

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

## Links

* [atoum](http://atoum.org)
* [atoum's documentation](http://docs.atoum.org)

## License

This extension is released under the MIT License. See the bundled [LICENSE](LICENSE) file for details.

![atoum](http://atoum.org/images/logo/atoum.png)

# SymfonyDependencyInjectionTest for Atoum

This extension is inspired by [SymfonyDependencyInjectionTest](https://github.com/matthiasnoback/SymfonyDependencyInjectionTest).

## Install it

Install extension using [composer](https://getcomposer.org):

```json
{
    "require-dev": {
        "jdecool/atoum-symfony-di": "~1.0"
    }
}
```

Enable the extension using atoum configuration file:

```php
<?php

// .atoum.php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use jdecool\atoum\symfonyDependencyInjection;

$runner->addExtension(new symfonyDependencyInjection\extension($script));
```

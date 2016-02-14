<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use jdecool\atoum\symfonyDependencyInjection;

$runner->addExtension(new symfonyDependencyInjection\extension($script));

$script->noCodeCoverageForNamespaces('mageekguy\atoum\asserters');
$script->noCodeCoverageForClasses('mageekguy\atoum\asserter');

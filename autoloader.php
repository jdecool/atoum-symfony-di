<?php

namespace jdecool\atoum\symfonyDependencyInjection;

use mageekguy\atoum;

atoum\autoloader::get()
	->addNamespaceAlias('atoum\symfonyDependencyInjection', __NAMESPACE__)
	->addDirectory(__NAMESPACE__, __DIR__ . DIRECTORY_SEPARATOR . 'classes');
;

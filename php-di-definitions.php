<?php

return array(
    'some.config.value' => '1',
    'some.other.config.value' => 10,

    'Example\FooInterface' => \DI\link('Example\Foo'),

    'Example\Baz' => \DI\object()
        ->methodParameter('__construct', 'someOtherConfigValue', \DI\link('some.other.config.value'))
);
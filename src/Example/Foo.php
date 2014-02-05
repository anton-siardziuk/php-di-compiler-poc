<?php

namespace Example;

class Foo implements FooInterface
{

    /**
     * @Inject("some.config.value")
     */
    private $someConfigValue = null;

    private $someOtherConfigValue = null;

    /**
     * @Inject({"some.other.config.value"})
     */
    public function __construct($someOtherConfigValue)
    {
        $this->someOtherConfigValue = $someOtherConfigValue;
    }
}
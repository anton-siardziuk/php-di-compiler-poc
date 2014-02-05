<?php


namespace Example;


class Baz
{
    private $bar = null;
    private $foo = null;
    private $someOtherConfigValue = null;

    public function __construct(Bar $bar, FooInterface $foo, $someOtherConfigValue)
    {
        $this->bar = $bar;
        $this->foo = $foo;
        $this->someOtherConfigValue = $someOtherConfigValue;
    }
}
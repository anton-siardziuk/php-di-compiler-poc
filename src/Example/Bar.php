<?php


namespace Example;


class Bar
{
    private $foo = null;

    public function __construct(FooInterface $foo)
    {
        $this->foo = $foo;
    }
}
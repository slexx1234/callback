<?php

use Slexx\Callback\Callback;
use PHPUnit\Framework\TestCase;

class TestClass
{
    public function method($arg = true)
    {
        return $arg;
    }

    public static function staticMethod()
    {
        return true;
    }
}

class CallbackTest extends TestCase
{
    public function testNotStaticMethod()
    {
        $this->assertTrue((new Callback('TestClass->method'))());
    }

    public function testStaticMethod()
    {
        $this->assertTrue((new Callback('TestClass::staticMethod'))());
    }

    public function testArguments()
    {
        $this->assertFalse((new Callback('TestClass->method'))(false));
    }
}
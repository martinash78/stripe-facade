<?php

use PHPUnit\Framework\TestCase;
use App\Dummy\DummyMethod;

class DummyMethodTest extends TestCase
{
    private $dummyMethod;

    public function setUp()
    {
        $this->dummyMethod = new DummyMethod();
    }

    public function testDummyErrorReturnsException()
    {
        $this->expectException(Exception::class);
        $this->dummyMethod->dummyError();
    }
}

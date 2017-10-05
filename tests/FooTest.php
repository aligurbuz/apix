<?php
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{
    public function testPushAndPop()
    {
        $stack = [];
        $this->assertEquals(0, count($stack));
    }
}
?>
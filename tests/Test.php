<?php

/**
 * Class Test
 */
class Test extends PHPUnit_Framework_TestCase
{
    /**
     * Create array test, This is just a simple test as an example
     */
    public function testCreateArray()
    {
        $stack = array();
        $this->assertEquals(0, count($stack));
    }
}

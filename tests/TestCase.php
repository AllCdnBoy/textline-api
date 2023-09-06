<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function mock($class)
    {
        $mock = \Mockery::mock($class);

        return $mock;
    }
}

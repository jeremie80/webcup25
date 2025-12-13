<?php

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    public function testBasicAssertion()
    {
        $this->assertTrue(true);
    }

    public function testAddition()
    {
        $result = 2 + 2;
        $this->assertEquals(4, $result);
    }

    public function testAppDirectoryExists()
    {
        $this->assertDirectoryExists(__DIR__ . '/../app');
    }

    public function testIndexFileExists()
    {
        $this->assertFileExists(__DIR__ . '/../index.php');
    }
}

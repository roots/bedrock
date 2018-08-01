<?php

namespace Tests;

class ExampleTest extends TestCase
{
    /** @test */
    function it_works()
    {
        $this->assertTrue(function_exists('add_action'));
    }
}

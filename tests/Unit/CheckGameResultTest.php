<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CheckGameResultTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->artisan('check:game-result')
            ->expectsQuestion('Enter A Teams players (enter drain by separating comma):', '30, 100, 20, 50, 40')
            ->expectsQuestion('Enter B Teams players (enter drain by separating comma):', '35, 10, 30, 20, 90')
            ->expectsOutput('Win')
            ->assertExitCode(0);
    }
}

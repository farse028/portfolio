<?php
namespace Yatzy\Test;

use Yatzy\YatzyGame;
use PHPUnit\Framework\TestCase;

class YatzyGameTest extends TestCase
{

    public function testConstructor()
    {
        $d = new YatzyGame();
        $this->assertEquals(0, $d->rollsRemaining);
    }

    public function testRoll()
    {
        $d = new YatzyGame();
        $this->assertEquals(3, $d->rollsRemaining);
        $d->roll();
        $this->assertEquals(2, $d->rollsRemaining);
    }
}
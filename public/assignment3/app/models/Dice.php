<?php
namespace Yatzy;

class Dice {
    private $state;
    public $min;
    public $max;

    //constructor
    function __construct($min = 1, $max = 6)
    {
        $this->min = $min;
        $this->max = $max;
        $this->state = rand($min,$max);
    }

    function roll(): int
    {
        $this->state = rand($this->min,$this->max);
        return $this->state;
    }

    function getState(): int {
        return $this->state;
    }
}
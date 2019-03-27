<?php

namespace spec\liamsorsby;

use liamsorsby\CircuitBreaker;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CircuitBreakerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CircuitBreaker::class);
    }
}

<?php

namespace Tests\DemoApplication;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;

class TestAggregateRoot implements AggregateRoot
{
    use AggregateRootBehaviour;

    private int $count = 0;

    public function increaseCounter(int $incrementBy)
    {
        $this->recordThat(CounterIncremented::with($incrementBy));
    }

    protected function applyCounterIncremented(CounterIncremented $event)
    {
        $this->count += $event->incrementBy;
    }
}

<?php

namespace Tests\DemoApplication;

use EventSourcingLaravel\EventSourcingLaravel\AbstractAggregateRootRepository;

class TestAggregateRootRepository extends AbstractAggregateRootRepository
{
    protected string $aggregateRootClassName = TestAggregateRoot::class;

    protected string $table = 'event_store';
}

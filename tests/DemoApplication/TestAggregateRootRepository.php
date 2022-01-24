<?php

namespace Tests\DemoApplication;

use EventSourcingLaravel\EventSourcingLaravel\AbstractAggregateRootRepository;

class TestAggregateRootRepository extends AbstractAggregateRootRepository
{
    public const TABLE = 'test_event_store';

    protected string $aggregateRootClassName = TestAggregateRoot::class;

    public string $table = self::TABLE;
}

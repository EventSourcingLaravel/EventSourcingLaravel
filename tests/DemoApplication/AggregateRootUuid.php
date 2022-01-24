<?php

namespace Tests\DemoApplication;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class AggregateRootUuid implements AggregateRootId
{

    private function __construct(private string $id)
    {
    }

    public static function create(): self
    {
        return new self(Uuid::uuid4());
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function fromString(string $aggregateRootId): AggregateRootId
    {
        if(!Uuid::isValid($aggregateRootId)){
            throw new \Exception("id is not a valid uuid");
        }
        return new self($aggregateRootId);
    }
}

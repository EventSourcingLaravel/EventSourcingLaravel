<?php

namespace Tests\DemoApplication;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class CounterIncremented implements SerializablePayload
{
    const INCREMENT_BY = 'incrementBy';

    private function __construct(public readonly int $incrementBy)
    {
    }

    public static function with(int $incrementBy)
    {
        return new self($incrementBy);
    }

    public function toPayload(): array
    {
        return [
            self::INCREMENT_BY => $this->incrementBy
        ];
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new self($payload[self::INCREMENT_BY]);
    }
}

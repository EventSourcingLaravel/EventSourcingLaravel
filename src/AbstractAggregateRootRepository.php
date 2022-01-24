<?php

namespace EventSourcingLaravel\EventSourcingLaravel;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\EventSourcedAggregateRootRepository;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateUuidV4MessageRepository;
use EventSauce\MessageRepository\TableSchema\TableSchema;
use EventSauce\UuidEncoding\StringUuidEncoder;
use Illuminate\Database\DatabaseManager;
use LogicException;

abstract class AbstractAggregateRootRepository extends  EventSourcedAggregateRootRepository
{
    protected string $aggregateRootClassName;

    protected string $connection = '';
    protected string $table = '';

    public function __construct(
        DatabaseManager $databaseManager,
        MessageDispatcher $dispatcher = null,
        MessageDecorator $decorator = null,
        ClassNameInflector $classNameInflector = null
    ) {
        if (! is_a($this->aggregateRootClassName, AggregateRoot::class, true)) {
            throw new LogicException('You have to set an aggregate root before the repository can be initialized.');
        }

        parent::__construct(
            $this->aggregateRootClassName,
            resolve(IlluminateUuidV4MessageRepository::class, [
                'connection' => $databaseManager->connection($this->connection),
                'tableName' => $this->table,
                'tableSchema' => $this->getTableSchema(),
                'uuidEncoder' => new StringUuidEncoder(),
            ]),
            $dispatcher,
            $decorator,
            $classNameInflector
        );
    }

    protected function getTableSchema(): TableSchema
    {
        return new DefaultTableSchema();
    }
}

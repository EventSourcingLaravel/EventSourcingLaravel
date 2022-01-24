<?php

namespace Tests\LibraryConsumptionTests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\DemoApplication\TestAggregateId;
use Tests\DemoApplication\TestAggregateRoot;
use Tests\DemoApplication\TestAggregateRootRepository;
use Tests\TestCase;

class AggregateRootRetrievalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrateEventTableWithTableName(TestAggregateRootRepository::TABLE);

    }

    /** @test */
    public function it_can_retrieve_a_aggregate()
    {
        /** @var TestAggregateRootRepository $testRepository */
        $testRepository = app(TestAggregateRootRepository::class);
        $aggregate = $testRepository->retrieve(TestAggregateId::create());
        $this->assertInstanceOf(TestAggregateRoot::class, $aggregate);
    }

    /** @test */
    public function it_can_persist_an_aggregate()
    {
        /** @var TestAggregateRootRepository $testRepository */
        $testRepository = app(TestAggregateRootRepository::class);

        $aggregateId = TestAggregateId::create();
        $aggregate = $testRepository->retrieve($aggregateId);

        $aggregate->increaseCounter(2);

        $testRepository->persist($aggregate);

        $this->assertDatabaseHas(TestAggregateRootRepository::TABLE, [
            'aggregate_root_id' => $aggregateId->toString()
        ]);
    }

    /** @test */
    public function table_can_be_configured_on_the_repository()
    {
        $this->migrateEventTableWithTableName('different_event_table_name');

        /** @var TestAggregateRootRepository $testRepository */
        $testRepository = app(TestAggregateRootWithDifferentTableName::class);

        $aggregateId = TestAggregateId::create();
        $aggregate = $testRepository->retrieve($aggregateId);

        $aggregate->increaseCounter(2);

        $testRepository->persist($aggregate);

        $this->assertDatabaseHas('different_event_table_name', [
            'aggregate_root_id' => $aggregateId->toString()
        ]);
    }
}

class TestAggregateRootWithDifferentTableName extends TestAggregateRootRepository
{
    public string $table = 'different_event_table_name';
}

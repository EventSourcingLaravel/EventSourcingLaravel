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

        Schema::create('event_store', function (Blueprint $table) {
            $table->uuid('event_id')->primary();
            $table->string('aggregate_root_id', 100)->index();
            $table->unsignedInteger('version');
            $table->text('payload');
            $table->dateTime('recorded_at', 6)->index();
            $table->string('event_type');

            $table->index(['aggregate_root_id', 'version'], 'reconstitution');
        });
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

        $this->assertDatabaseHas('event_store', [
            'aggregate_root_id' => $aggregateId->toString()
        ]);
    }
}

<?php

namespace Tests;

use EventSourcingLaravel\EventSourcingLaravel\EventSourcingServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [EventSourcingServiceProvider::class];
    }

    protected function migrateEventTableWithTableName(string $tableName)
    {
        Schema::create($tableName, function (Blueprint $table) {
            $table->uuid('event_id')->primary();
            $table->string('aggregate_root_id', 100)->index();
            $table->unsignedInteger('version');
            $table->text('payload');
            $table->dateTime('recorded_at', 6)->index();
            $table->string('event_type');
        });
    }
}

<?php

namespace EventSourcingLaravel\EventSourcingLaravel;

use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\MessageRepository\IlluminateMessageRepository\IlluminateUuidV4MessageRepository;
use Illuminate\Support\ServiceProvider;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function boot()
    {
//        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//
//        if ($this->app->runningInConsole()) {
//            $this->publishes([
//                __DIR__.'/../config/eventsauce.php' => $this->app->configPath('eventsauce.php'),
//            ], ['eventsauce', 'eventsauce-config']);
//
//            $this->publishes([
//                __DIR__.'/../database/migrations' => $this->app->databasePath('migrations'),
//            ], ['eventsauce', 'eventsauce-migrations']);
//        }
    }

    public function register()
    {
//        $this->mergeConfigFrom(__DIR__.'/../config/eventsauce.php', 'eventsauce');

//        $this->app->bind(MessageRepository::class, function ($app) {
//            return $app->make(IlluminateUuidV4MessageRepository::class);
//        });
        $this->app->bind(MessageSerializer::class, function ($app) {
            return $app->make(ConstructingMessageSerializer::class);
        });

        $this->app->bind(MessageDecorator::class, function ($app) {
            return $app->make(DefaultHeadersDecorator::class);
        });
    }

//    public function provides()
//    {
//        return [
//            GenerateCommand::class,
//            MakeAggregateRootCommand::class,
//            MakeConsumerCommand::class,
//        ];
//    }
}

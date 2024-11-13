<?php

use App\Service\Pinger;
use GRPC\Pinger\PingerInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';

$server = new Server();

$server->registerService(
    interface: PingerInterface::class,
    service: new Pinger(
        httpClient: Symfony\Component\HttpClient\HttpClient::create()
    )
);

$server->serve(Worker::create());
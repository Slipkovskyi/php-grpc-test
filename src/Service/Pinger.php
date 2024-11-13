<?php

namespace App\Service;

use GRPC\Pinger\PingerInterface;
use GRPC\Pinger\PingRequest;
use GRPC\Pinger\PingResponse;
use Spiral\RoadRunner\GRPC;
use Spiral\RoadRunner\GRPC\ContextInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Pinger implements PingerInterface
{
    /**
     * @param HttpClientInterface $httpClient
     */
    public function __construct(private HttpClientInterface $httpClient)
    {
    }

    /**
     * @param ContextInterface $ctx
     * @param PingRequest $in
     * @return PingResponse
     * @throws TransportExceptionInterface
     */
    public function ping(GRPC\ContextInterface $ctx, PingRequest $in): PingResponse
    {
        $statusCode = $this->httpClient->request('GET', $in->getUrl())->getStatusCode();
        return (new PingResponse())->setStatusCode($statusCode);
    }
}
<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Entities\Order;
use App\Services\PaymentService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class PaymentServiceTest extends TestCase
{
    public function testPay(): void
    {
        // arrange
        $order = new Order();
        /** @var Client $client */
        $client = \Mockery::mock(Client::class)
            ->shouldReceive('get')
            ->with('https://ya.ru')
            ->once()
            ->andReturnUsing(
                static fn () => \Mockery::mock(ResponseInterface::class)
                ->shouldReceive('getStatusCode')
                ->once()
                ->andReturn(200)
                ->getMock()
            )
            ->getMock();
        $service = new PaymentService($client);

        // assert
        self::assertTrue($service->pay($order));
    }

    public function testPayWithChangeEndpoint(): void
    {
        // arrange
        $order = new Order();
        /** @var Client $client */
        $client = \Mockery::mock(Client::class)
            ->shouldReceive('get')
            ->with('https://google.com')
            ->once()
            ->andReturnUsing(
                static fn () => \Mockery::mock(ResponseInterface::class)
                ->shouldReceive('getStatusCode')
                ->once()
                ->andReturn(200)
                ->getMock()
            )
            ->getMock();
        $service = new PaymentService($client, 'https://google.com');

        // assert
        self::assertTrue($service->pay($order));
    }

    public function testFailedPay(): void
    {
        // arrange
        $order = new Order();
        /** @var Client $client */
        $client = \Mockery::mock(Client::class)
            ->shouldReceive('get')
            ->with('https://ya.ru')
            ->once()
            ->andReturnUsing(
                static fn () => \Mockery::mock(ResponseInterface::class)
                ->shouldReceive('getStatusCode')
                ->once()
                ->andReturn(404)
                ->getMock()
            )
            ->getMock();
        $service = new PaymentService($client);

        // assert
        self::assertFalse($service->pay($order));
    }
}

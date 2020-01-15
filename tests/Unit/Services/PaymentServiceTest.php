<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Entities\Order;
use App\Services\PaymentService;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class PaymentServiceTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = \Mockery::mock(Client::class);
    }

    public function testPay(): void
    {
        // arrange
        $order = new Order();
        $this->mockHttpRequest('https://ya.ru', Response::HTTP_OK);
        $service = new PaymentService($this->client);

        // assert
        self::assertTrue($service->pay($order));
    }

    public function testPayWithChangeEndpoint(): void
    {
        // arrange
        $order = new Order();
        $this->mockHttpRequest('https://google.com', Response::HTTP_OK);
        $service = new PaymentService($this->client, 'https://google.com');

        // assert
        self::assertTrue($service->pay($order));
    }

    public function testFailedPay(): void
    {
        // arrange
        $order = new Order();
        $this->mockHttpRequest('https://ya.ru', Response::HTTP_NOT_FOUND);
        $service = new PaymentService($this->client);

        // assert
        self::assertFalse($service->pay($order));
    }

    private function mockHttpRequest(string $url, int $statusCode): void
    {
        $this->client
            ->shouldReceive('get')
            ->with($url)
            ->once()
            ->andReturnUsing(
                static fn () => \Mockery::mock(ResponseInterface::class)
                    ->shouldReceive('getStatusCode')
                    ->once()
                    ->andReturn($statusCode)
                    ->getMock()
            )
            ->getMock();
    }
}

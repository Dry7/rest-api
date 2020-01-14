<?php

declare(strict_types=1);

namespace App\Services;

use App\Entities\Order;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class PaymentService
{
    private Client $client;
    private string $endpoint = 'https://ya.ru';

    public function __construct(Client $client, string $endpoint = null)
    {
        $this->client = $client;
        $this->endpoint ??= $endpoint;
    }

    public function pay(Order $order): bool
    {
        return $this->client->get($this->endpoint)->getStatusCode() === Response::HTTP_OK;
    }
}

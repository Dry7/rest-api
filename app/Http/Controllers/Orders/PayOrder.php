<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Entities\Order;
use App\Entities\Product;
use App\Exceptions\OrderException;
use App\Http\Views\OrderView;
use App\Http\Views\SuccessOrderPay;
use App\Request;
use App\Services\PaymentService;
use Doctrine\ORM\EntityManagerInterface;

class PayOrder
{
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        PaymentService $paymentService
    ): SuccessOrderPay
    {
        $data = $request->jsonContent();

        if (!isset($data->id)) {
            throw OrderException::emptyOrderId();
        }

        if (!isset($data->sum)) {
            throw OrderException::emptySum();
        }

        /** @var Order $order */
        $order = $entityManager->getRepository(Order::class)->find($data->id);

        if ($order->getStatus() !== Order::STATUS_NEW) {
            throw OrderException::invalidStatus();
        }

        $sum = array_reduce(
            $order->products()->toArray(),
            static fn (float $sum, Product $product) => $sum + $product->getPrice(),
            0.0
        );

        if (!$this->comparePrices($sum, $data->sum)) {
            throw OrderException::invalidSum();
        }

        if (!$paymentService->pay($order)) {
            throw OrderException::failedPay();
        }

        $order->setStatus(Order::STATUS_PAID);

        $entityManager->persist($order);
        $entityManager->flush();

        return new SuccessOrderPay($order);
    }

    private function comparePrices(float $a, float $b): bool
    {
        return abs($a - $b) < 0.009;
    }
}

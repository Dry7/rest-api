<?php

declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Entities\Order;
use App\Entities\Product;
use App\Exceptions\OrderException;
use App\Http\Views\OrderView;
use App\Request;
use App\Services\AuthService;
use Doctrine\ORM\EntityManagerInterface;

class CreateOrder
{
    public function __invoke(
        Request $request,
        EntityManagerInterface $entityManager,
        AuthService $authService
    ): OrderView {
        $ids = $request->jsonContent();

        if (empty($ids)) {
            throw OrderException::emptyProducts();
        }

        $products = $entityManager
            ->getRepository(Product::class)
            ->findByIDs(...array_map(static fn ($id) => (int)$id, $ids));

        if (count($ids) !== count($products)) {
            throw OrderException::someProductsNotFound();
        }

        $user = $authService->getUser();
        $order = Order::createFromProducts($products);
        $order->setUser($user);

        $entityManager->persist($order);
        $entityManager->flush();

        return new OrderView($order);
    }
}

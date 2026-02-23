<?php

declare(strict_types=1);

namespace App;

use App\Calculator\ShippingCalculatorResolver;
use App\Model\Order;

final class OrderProcessor
{
    /**
     * Create an order processor with the given calculator resolver.
     *
     * @param ShippingCalculatorResolver $resolver Resolver used to find the cost calculator by method.
     */
    public function __construct(
        private ShippingCalculatorResolver $resolver,
    ) {}

    /**
     * Process an order and return the shipping cost breakdown.
     *
     * @param Order $order The order to process.
     * @return array<string, int|float> Cost breakdown (base_cost, weight_cost, insurance_cost, extra_cost, total_cost).
     */
    public function process(Order $order): array
    {
        $shippingCostCalculator = $this->resolver->resolve($order->method);

        return $shippingCostCalculator->apply($order);
    }
}

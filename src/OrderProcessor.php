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
     * @param ShippingCalculatorResolver $resolver 
     */
    public function __construct(
        private ShippingCalculatorResolver $resolver,
    ) {}

    /**
     * Process an order and return the shipping cost breakdown.
     *
     * @param Order $order The order to process.
     * @return array<string, int|float> 
     */
    public function process(Order $order): array
    {
        $shippingCostCalculator = $this->resolver->resolve($order->method);

        return $shippingCostCalculator->apply($order);
    }
}
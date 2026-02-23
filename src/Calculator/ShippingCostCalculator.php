<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Enum\MethodName;
use App\Model\Order;

interface ShippingCostCalculator
{
    /**
     * Whether this calculator supports the given shipping method.
     *
     * @param MethodName $method The shipping method to check.
     * @return bool True if this calculator handles the method, false otherwise.
     */
    public function supports(MethodName $method): bool;

    /**
     * Calculate shipping cost breakdown for the given order.
     *
     * @param Order $order The order to calculate costs for.
     * @return array<string, int|float> Cost breakdown (base_cost, weight_cost, insurance_cost, extra_cost, total_cost).
     */
    public function apply(Order $order): array;
}
<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Enum\MethodName;
use App\Model\Order;

class CalculateSameDayCost implements ShippingCostCalculator
{
    private const WEIGHT_LIMIT = 3;
    private const FIXED_COST = 120000;

    /**
     * Whether this calculator supports the given shipping method.
     *
     * @param MethodName $method The shipping method to check.
     * @return bool True if this calculator handles the method, false otherwise.
     */
    public function supports(MethodName $method): bool
    {
        return $method === MethodName::SameDay;
    }

    /**
     * Calculate shipping cost for Same Day delivery (fixed cost, weight limit applies).
     *
     * @param Order $order The order to calculate costs for.
     * @return array<string, int|float> Cost breakdown (base_cost, weight_cost, insurance_cost, extra_cost, total_cost).
     * @throws \InvalidArgumentException When order weight exceeds the Same Day limit.
     */
    public function apply(Order $order): array
    {
        if ($order->weight > self::WEIGHT_LIMIT) {
            throw new \InvalidArgumentException('Weight limit exceeded');
        }

        return [
            'base_cost' => self::FIXED_COST,
            'weight_cost' => 0,
            'insurance_cost' => 0,
            'extra_cost' => 0,
            'total_cost' => self::FIXED_COST
        ];
    }
}

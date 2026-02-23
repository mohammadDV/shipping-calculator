<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Enum\MethodName;
use App\Model\Order;

class CalculateStandardCost implements ShippingCostCalculator
{
    private const BASE_PRICE = 30000;
    private const PRICE_PER_KG = 10000;
    private const EXTRA_PERCENTAGE = 15;
    private const INSURANCE_PERCENTAGE = 1;

    private const WEIGHT_LIMIT = 5;
    private const INSURANCE_LIMIT = 5000000;

    /**
     * Whether this calculator supports the given shipping method.
     *
     * @param MethodName $method The shipping method to check.
     * @return bool True if this calculator handles the method, false otherwise.
     */
    public function supports(MethodName $method): bool
    {
        return $method === MethodName::Standard;
    }

    /**
     * Calculate shipping cost breakdown for the given order (Standard method).
     *
     * @param Order $order The order to calculate costs for.
     * @return array<string, int|float> Cost breakdown (base_cost, weight_cost, insurance_cost, extra_cost, total_cost).
     */
    public function apply(Order $order): array
    {
        $baseCost = self::BASE_PRICE;
        $weightCost = $order->weight * self::PRICE_PER_KG;
        $extraCost = $this->calculateExtraCost($order, $baseCost + $weightCost);
        $insuranceCost = $this->calculateInsuranceCost($order);

        return [
            'base_cost' => $baseCost,
            'weight_cost' => $weightCost,
            'insurance_cost' => $insuranceCost,
            'extra_cost' => $extraCost,
            'total_cost' => $baseCost + $weightCost + $insuranceCost + $extraCost
        ];
    }

    /**
     * Calculate extra cost when order weight exceeds the limit.
     *
     * @param Order $order The order.
     * @param float $totalCost Subtotal (base + weight cost) before extra.
     * @return int Extra cost amount.
     */
    private function calculateExtraCost(Order $order, float $totalCost): int
    {
        $extraCost = 0;
        if ($order->weight > self::WEIGHT_LIMIT && self::EXTRA_PERCENTAGE > 0) {
            $extraCost += (int) ($totalCost * self::EXTRA_PERCENTAGE / 100);
        }
        return $extraCost;
    }

    /**
     * Calculate insurance cost when order value exceeds the limit.
     *
     * @param Order $order The order.
     * @return int Insurance cost amount.
     */
    private function calculateInsuranceCost(Order $order): int
    {
        $extraCost = 0;
        if ($order->value > self::INSURANCE_LIMIT && self::INSURANCE_PERCENTAGE > 0) {
            $extraCost += (int) ($order->value * self::INSURANCE_PERCENTAGE / 100);
        }
        return $extraCost;
    }
}

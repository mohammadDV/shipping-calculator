<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Enum\MethodName;

class ShippingCalculatorResolver
{
    /**
     * Create a resolver with the list of available cost calculators.
     *
     * @param ShippingCostCalculator[] $calculators Calculators to use for resolving by method.
     */
    public function __construct(
        private array $calculators
    ) {}

    /**
     * Resolve the appropriate cost calculator for the given shipping method.
     *
     * @param MethodName $method The shipping method to resolve.
     * @return ShippingCostCalculator The calculator that supports the method.
     * @throws \RuntimeException When no calculator supports the method.
     */
    public function resolve(MethodName $method): ShippingCostCalculator
    {
        foreach ($this->calculators as $calculator) {
            if ($calculator->supports($method)) {
                return $calculator;
            }
        }

        throw new \RuntimeException('Unsupported shipping method');
    }
}

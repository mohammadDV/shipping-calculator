<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\CityName;
use App\Enum\MethodName;

class Order
{
    /**
     * Create an order with weight, destination city, shipping method, and declared value.
     *
     * @param float $weight Order weight in kg.
     * @param CityName $city Destination city.
     * @param MethodName $method Shipping method (Standard, Express, SameDay).
     * @param float $value Declared value for insurance.
     */
    public function __construct(
        public float $weight,
        public CityName $city,
        public MethodName $method,
        public float $value,
    ) {}
}

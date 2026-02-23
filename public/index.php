<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Calculator\CalculateExpressCost;
use App\Calculator\CalculateSameDayCost;
use App\Calculator\CalculateStandardCost;
use App\Calculator\ShippingCalculatorResolver;
use App\Enum\CityName;
use App\Enum\MethodName;
use App\Model\Order;
use App\OrderProcessor;
use App\Validation\ValidateData;

$resolver = new ShippingCalculatorResolver([
    new CalculateStandardCost(),
    new CalculateExpressCost(),
    new CalculateSameDayCost(),
]);

$processor = new OrderProcessor($resolver);

$data = '{
    "weight": 6,
    "city": "Tehran",
    "method": "Standard",
    "value": 6000000
}';

$data = (new ValidateData())->validate($data);

$order = new Order(
    (float) $data['weight'],
    CityName::from($data['city']),
    MethodName::from($data['method']),
    (float) $data['value']
);

$result = $processor->process($order);

print_r($result);

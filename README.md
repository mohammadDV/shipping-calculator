# Shipping Cost Calculator

A small PHP application that calculates shipping costs based on order weight, destination city, shipping method, and declared value.

## Requirements

- PHP 8.1 or higher
- [Composer](https://getcomposer.org/)

## Installation

```bash
composer install
```

## Usage

Run the entry point (uses sample JSON input):

```bash
php public/index.php
```

### Input

The app expects JSON with:

| Field   | Type   | Description                          |
|---------|--------|--------------------------------------|
| `weight`| number | Order weight in kg                   |
| `city`  | string | Destination: `Tehran`, `Mashhad`, `Tabriz` |
| `method`| string | Shipping method: `Standard`, `Express`, `SameDay` |
| `value` | number | Declared value (used for insurance)  |

### Output

A cost breakdown array:

- `base_cost` — Base shipping fee
- `weight_cost` — Cost by weight
- `insurance_cost` — Insurance (when value exceeds limit)
- `extra_cost` — Extra fees (e.g. overweight, special city)
- `total_cost` — Sum of all costs

### Example

**Input:**

```json
{
    "weight": 6,
    "city": "Tehran",
    "method": "Standard",
    "value": 6000000
}
```

**Output:**

```
Array
(
    [base_cost] => 30000
    [weight_cost] => 60000
    [insurance_cost] => 60000
    [extra_cost] => 13500
    [total_cost] => 163500
)
```

## Shipping Methods

| Method    | Notes |
|-----------|--------|
| **Standard** | Base + per-kg; extra % over 5 kg; insurance over 5M value |
| **Express**  | Higher base/per-kg; extra % for Mashhad; insurance over 3M value |
| **Same Day** | Fixed cost; max weight 3 kg |

## Project Structure

```
├── composer.json
├── public/
│   └── index.php          # Entry point
└── src/
    ├── Enum/
    │   ├── CityName.php   # Tehran, Mashhad, Tabriz
    │   └── MethodName.php # Standard, Express, SameDay
    ├── Model/
    │   └── Order.php      # Order (weight, city, method, value)
    ├── Calculator/
    │   ├── ShippingCostCalculator.php   # Interface
    │   ├── CalculateStandardCost.php
    │   ├── CalculateExpressCost.php
    │   ├── CalculateSameDayCost.php
    │   └── ShippingCalculatorResolver.php
    ├── Validation/
    │   └── ValidateData.php
    └── OrderProcessor.php
```

- **OrderProcessor** — Resolves the right calculator by method and runs it.
- **ShippingCalculatorResolver** — Picks a calculator that supports the given method.
- **ValidateData** — Validates and decodes JSON input.

## License

Unlicensed.

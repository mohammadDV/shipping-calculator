<?php

declare(strict_types=1);

namespace App\Validation;

use App\Enum\CityName;
use App\Enum\MethodName;

final class ValidateData
{
    /**
     * Validate and decode JSON order data into an associative array.
     *
     * @param string $data JSON string containing weight, city, method, and value.
     * @return array<string, mixed> Validated order data (weight, city, method, value).
     * @throws \InvalidArgumentException When JSON is invalid or required fields are missing/invalid.
     */
    public function validate(string $data): array
    {
        $data = json_decode($data, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException('Invalid JSON');
        }

        if (!isset($data['weight']) || !isset($data['city']) || !isset($data['method']) || !isset($data['value'])) {
            throw new \InvalidArgumentException('Invalid arguments');
        }

        if (!is_numeric($data['weight']) || !is_numeric($data['value'])) {
            throw new \InvalidArgumentException('Invalid arguments');
        }

        if (!in_array($data['method'], array_column(MethodName::cases(), 'value'))) {
            throw new \InvalidArgumentException('Invalid method');
        }

        if (!in_array($data['city'], array_column(CityName::cases(), 'value'))) {
            throw new \InvalidArgumentException('Invalid city');
        }

        return $data;
    }
}

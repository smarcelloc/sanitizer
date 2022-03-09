<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Illuminate\Support\Collection;
use Sanitizer\Filter;

class Cast extends Filter
{
    protected $allowType = ['string', 'integer', 'double', 'array', 'boolean'];

    /**
     * Value the given according with type cast.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function apply($value, array $options = [])
    {
        $type = $options[0] ?? null;

        switch ($type) {
            case 'integer':
                return !is_array($value) ? intval($value) : $value;

            case 'double':
                return !is_array($value) ? floatval($value) : $value;

            case 'string':
                return !is_array($value) ? strval($value) : $value;

            case 'boolean':
                return !is_array($value) ? boolval($value) : $value;

            case 'object':
                if (is_array($value)) {
                    return (object) $value;
                }

                if (is_string($value)) {
                    return json_decode($value, false);
                }

                return $value;

            case 'array':
                return is_string($value) ? json_decode($value, true) : $value;

            case 'collection':
                if (is_string($value)) {
                    $value = json_decode($value, true);
                }

                if (!is_array($value)) {
                    return $value;
                }

                return new Collection($value);

            default:
                throw new \InvalidArgumentException("Wrong Sanitizer casting format: {$type}.");
        }
    }
}

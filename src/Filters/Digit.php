<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class Digit extends Filter
{
    protected $allowType = ['string', 'integer', 'double'];

    /**
     * Get only digit characters from the string.
     *
     * @param float|int|string $value
     *
     * @return int|string
     */
    public function apply($value)
    {
        if (is_string($value)) {
            $valueDigit = preg_replace('/[^0-9]/si', '', $value);

            if ($valueDigit === null) {
                return $value;
            }

            return $valueDigit;
        }

        return intval($value);
    }
}

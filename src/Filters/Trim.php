<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class Trim extends Filter
{
    protected $allowType = ['string'];

    /**
     * Trims the given string.
     */
    public function apply(string $value): string
    {
        return trim($value);
    }
}

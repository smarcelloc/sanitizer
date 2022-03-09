<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class Lowercase extends Filter
{
    protected $allowType = ['string'];

    /**
     * Lowercase the given string.
     */
    public function apply(string $value): string
    {
        return mb_strtolower($value);
    }
}

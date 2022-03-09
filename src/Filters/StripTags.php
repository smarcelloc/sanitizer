<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class StripTags extends Filter
{
    protected $allowType = ['string'];

    /**
     * Strip tags from the given string.
     */
    public function apply(string $value): string
    {
        return strip_tags($value);
    }
}

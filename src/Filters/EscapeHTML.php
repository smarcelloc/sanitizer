<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class EscapeHTML extends Filter
{
    protected $allowType = ['string'];

    /**
     * Remove HTML tags and encode special characters from the given string.
     */
    public function apply(string $value): string
    {
        return htmlspecialchars($value);
    }
}

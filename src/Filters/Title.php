<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class Title extends Filter
{
    protected $allowType = ['string'];

    /**
     * Title the given string.
     */
    public function apply(string $value): string
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }
}

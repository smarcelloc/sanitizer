<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Contracts\Filter;

class Capitalize implements Filter
{
    /**
     * Capitalize the given string.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        return mb_convert_case($value, MB_CASE_TITLE);
    }
}

<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Contracts\Filter;

class Uppercase implements Filter
{
    /**
     * Uppercase the given string.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        return mb_strtoupper($value);
    }
}

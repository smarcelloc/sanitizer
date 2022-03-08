<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Contracts\Filter;

class Lowercase implements Filter
{
    /**
     *  Lowercase the given string.
     *
     *  @param  string  $value
     * @param mixed $options
     *
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? mb_strtolower($value, 'UTF-8') : $value;
    }
}

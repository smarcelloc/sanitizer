<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Contracts\Filter;

class Digit implements Filter
{
    /**
     *  Get only digit characters from the string.
     *
     *  @param  string  $value
     * @param mixed $options
     *
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return preg_replace('/[^0-9]/si', '', $value);
    }
}

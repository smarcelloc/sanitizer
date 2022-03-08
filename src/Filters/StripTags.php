<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Contracts\Filter;

class StripTags implements Filter
{
    /**
     *  Strip tags from the given string.
     *
     *  @param  string  $value
     * @param mixed $options
     *
     *  @return string
     */
    public function apply($value, $options = [])
    {
        return is_string($value) ? strip_tags($value) : $value;
    }
}

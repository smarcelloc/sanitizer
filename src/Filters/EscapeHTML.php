<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Contracts\Filter;

class EscapeHTML implements Filter
{
    /**
     * Remove HTML tags and encode special characters from the given string.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        return htmlspecialchars($value);
    }
}

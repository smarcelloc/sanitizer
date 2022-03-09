<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Sanitizer\Filter;

class FilterIf extends Filter
{
    protected $allowType = ['array'];

    /**
     * Checks if filters should run if there is value passed that matches.
     */
    public function apply(array $values, array $options = []): bool
    {
        return array_key_exists($options[0], $values) && $values[$options[0]] === $options[1];
    }
}

<?php

declare(strict_types=1);

namespace Sanitizer\Contracts;

interface Filter
{
    /**
     * Return the result of applying this filter to the given input.
     *
     * @param mixed $value
     * @param mixed $options
     *
     * @return mixed
     */
    public function apply($value, $options = []);
}

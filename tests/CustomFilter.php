<?php

declare(strict_types=1);

use Sanitizer\Contracts\Filter;

class CustomFilter implements Filter
{
    public function apply($value, $options = [])
    {
        return $value . $value;
    }
}

<?php

declare(strict_types=1);

use Sanitizer\Filter;

class CustomFilter extends Filter
{
    protected $allowType = ['string'];

    public function apply($value)
    {
        return $value . $value;
    }
}

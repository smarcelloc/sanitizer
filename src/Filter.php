<?php

declare(strict_types=1);

namespace Sanitizer;

/**
 * @method mixed apply(mixed $value, array $options)
 */
class Filter
{
    /**
     * Choose allows types variables to apply filter.
     *
     * @var array - Example: ['string', 'integer', 'boolean', 'double', 'array']
     */
    protected $allowType = [];

    /**
     * Return the result of applying this filter to the given input.
     *
     * @param mixed $value
     * @param string[] $options
     *
     * @return mixed
     */
    final public function applyFilter($value, array $options = [])
    {
        if (count($this->allowType) > 0 && !in_array(gettype($value), $this->allowType, true)) {
            return $value;
        }

        return $this->apply($value, $options);
    }
}

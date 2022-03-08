<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Carbon\Carbon;
use Sanitizer\Contracts\Filter;

class FormatDate implements Filter
{
    /**
     * Value the given date format.
     *
     * @param string $value
     * @param array $options
     *
     * @return string
     */
    public function apply($value, $options = [])
    {
        if (sizeof($options) !== 2) {
            throw new \InvalidArgumentException('The Sanitizer Format Date filter requires both the current date format as well as the target format.');
        }

        $currentFormat = $options[0];
        $targetFormat = $options[1];

        if (!$value) {
            return $value;
        }

        $date = Carbon::createFromFormat($currentFormat, $value);

        if ($date instanceof Carbon) {
            return $date->format($targetFormat);
        }

        return $value;
    }
}

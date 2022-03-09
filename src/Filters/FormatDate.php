<?php

declare(strict_types=1);

namespace Sanitizer\Filters;

use Carbon\Carbon;
use Sanitizer\Filter;

class FormatDate extends Filter
{
    protected $allowType = ['string'];

    /**
     * Value the given date format.
     */
    public function apply(string $value, array $options = []): string
    {
        if (!$value) {
            return $value;
        }

        if (count($options) !== 2) {
            throw new \InvalidArgumentException('The Sanitizer Format Date filter requires both the current date format as well as the target format.');
        }

        $currentFormat = $options[0];
        $targetFormat = $options[1];

        $data = Carbon::createFromFormat($currentFormat, $value);

        if ($data instanceof Carbon) {
            return $data->format($targetFormat);
        }

        return $value;
    }
}

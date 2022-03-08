<?php

declare(strict_types=1);

namespace Sanitizer\Test;

use Sanitizer\Sanitizer;

trait SanitizerTrait
{
    /**
     * @param mixed $data
     * @param mixed $rules
     *
     * @return mixed
     */
    public function sanitize($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules);

        return $sanitizer->sanitize();
    }
}

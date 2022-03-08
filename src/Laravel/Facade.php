<?php

declare(strict_types=1);

namespace Sanitizer\Laravel;

use Illuminate\Support\Facades\Facade as LaravelFacade;

/**
 * @see \Illuminate\Validation\Factory
 */
class Facade extends LaravelFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'sanitizer';
    }
}

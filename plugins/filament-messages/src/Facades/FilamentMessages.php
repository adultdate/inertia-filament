<?php

declare(strict_types=1);

namespace Adultdate\FilamentMessages\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Adultdate\FilamentMessages\FilamentMessages
 */
final class FilamentMessages extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \Adultdate\FilamentMessages\FilamentMessages::class;
    }
}

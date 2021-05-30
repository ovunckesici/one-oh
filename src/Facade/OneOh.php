<?php

namespace Doranetyazilim\OneOh\Facade;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Doranetyazilim\OneOh\Skeleton\SkeletonClass
 */
class OneOh extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'one-oh';
    }
}

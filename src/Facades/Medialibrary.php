<?php

namespace Themightysapien\Medialibrary\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Themightysapien\Medialibrary\Skeleton\SkeletonClass
 */
class Medialibrary extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'medialibrary';
    }
}

<?php

namespace Themightysapien\MediaLibrary\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Themightysapien\MediaLibrary\Skeleton\SkeletonClass
 */
class MediaLibrary extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'themightysapienmedialibrary';
    }
}

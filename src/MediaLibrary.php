<?php

namespace Themightysapien\MediaLibrary;

use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Themightysapien\MediaLibrary\Models\Library;

class MediaLibrary
{
    /**
     * @return Library
     */
    public function init()
    {
        return Library::firstOrNew([]);
    }

    /**
     * @return Library
     */
    public function open()
    {
        return $this->init();
    }


    /**
     * Add media to library
     * @param mixed $path
     *
     * @return Media
     */
    public function addMedia(string|\Symfony\Component\HttpFoundation\File\UploadedFile $file): Media
    {
        $library = MediaLibrary::open();

        return $library->addMedia($file)
            // ->preservingOriginal()
            ->toMediaCollection(Config::get('mlibrary.collection_name', 'library'));
    }

    /**
     * Clear out the library
     *
     * @return void
     */
    public function clear()
    {
        $this->init()->clearMediaCollection(Config::get('mlibrary.collection_name', 'library'));
    }
}

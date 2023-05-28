<?php

namespace Themightysapien\MediaLibrary;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
        return Library::firstOrCreate([]);
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
     * @param mixed $file
     *
     * @return Media
     */
    public function addMedia(string|\Symfony\Component\HttpFoundation\File\UploadedFile $file): Media
    {
        $library = MediaLibrary::open();
        // print_r($library);

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


    /**
     * @return Collection
     */
    public function allMedia(): Collection
    {
        return $this->init()->getMedia(Config::get('mlibrary.collection_name', 'library'));
    }


    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->init()->media();
    }
}

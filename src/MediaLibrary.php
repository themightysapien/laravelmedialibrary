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
    public function init($user_id = null)
    {
        return Library::firstOrCreate(['user_id' => $user_id]);
    }

    /**
     * @return Library
     */
    public function open($user_id = null)
    {
        return $this->init($user_id);
    }


    /**
     * Add media to library
     * @param mixed $file
     * @param number $user_id
     *
     * @return Media
     */
    public function addMedia(string|\Symfony\Component\HttpFoundation\File\UploadedFile $file, $user_id = null): Media
    {
        $library = MediaLibrary::open($user_id);
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
    public function clear($user_id = null)
    {
        $this->init($user_id)->clearMediaCollection(Config::get('mlibrary.collection_name', 'library'));
    }


    /**
     * @return Collection
     */
    public function allMedia($user_id = null): Collection
    {
        return $this->init($user_id)->getMedia(Config::get('mlibrary.collection_name', 'library'));
    }


    /**
     * @return Builder
     */
    public function query($user_id = null): Builder
    {
        // return $this->init($user_id)->media()->query();
        $library = $this->init($user_id);
        return Media::query()->where('model_id', $library->id)->where('model_type', Library::class);
    }
}

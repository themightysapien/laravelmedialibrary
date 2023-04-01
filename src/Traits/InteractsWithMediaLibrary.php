<?php

namespace Themightysapien\Medialibrary\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Themightysapien\Medialibrary\Models\Library;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Themightysapien\Medialibrary\Facades\Medialibrary;

trait InteractsWithMediaLibrary
{

    /*
    @params $media Media|int
    */
    public function addMediaFromLibrary($media)
    {
        if (!$media instanceof Media) {
            $media = Media::findOrFail($media);
        }

        return $this
            ->addMediaFromDisk($media->getPathRelativeToRoot(), Config::get('media-library.disk_name'))
            ->preservingOriginal();
    }


    public function addMediaByAddingToLibrary($path)
    {
        $library = Medialibrary::init();

        $media = $library->addMedia($path)
            // ->preservingOriginal()
            ->toMediaCollection(Config::get('mlibrary.collection_name', 'library'));

            dump($media);

        // $media = $library->media()->latest()->first();
        // dump($media->getPath());
        // dump(Storage::disk(Config::get('media-library.disk_name'))->path($media->getPathRelativeToRoot()));

        return $this->addMediaFromLibrary($media);
    }
}

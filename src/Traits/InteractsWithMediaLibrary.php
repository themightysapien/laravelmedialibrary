<?php

namespace Themightysapien\Medialibrary\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Themightysapien\Medialibrary\Models\Library;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Themightysapien\Medialibrary\Facades\Medialibrary;

trait InteractsWithMediaLibrary
{


    /**
     * @param Media $media
     *
     * @return FileAdder
     */
    public function addMediaFromLibrary(Media $media): FileAdder
    {
        if (!$media instanceof Media) {
            $media = Media::findOrFail($media);
        }

        return $this
            ->addMediaFromDisk($media->getPathRelativeToRoot(), Config::get('media-library.disk_name'))
            ->preservingOriginal();
    }


    /**
     * @param string|\Symfony\Component\HttpFoundation\File\UploadedFile $file
     *
     * @return FileAdder
     */
    public function addMediaThroughLibrary(string|\Symfony\Component\HttpFoundation\File\UploadedFile $file): FileAdder
    {


        $media = Medialibrary::addMedia($file);
        // dump($media);

        // $media = $library->media()->latest()->first();
        // dump($media->getPath());
        // dump(Storage::disk(Config::get('media-library.disk_name'))->path($media->getPathRelativeToRoot()));

        return $this->addMediaFromLibrary($media);
    }



}

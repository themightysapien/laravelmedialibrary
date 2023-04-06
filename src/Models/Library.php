<?php

namespace Themightysapien\MediaLibrary\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Library extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Config::get('mlibrary.table_name'));
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(Config::get('mlibrary.thumbnail.width'))
            ->height(Config::get('mlibrary.thumbnail.height'));
    }
}

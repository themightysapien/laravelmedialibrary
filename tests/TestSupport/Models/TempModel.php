<?php

namespace Themightysapien\MediaLibrary\Tests\TestSupport\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Themightysapien\MediaLibrary\Traits\UseMediaLibraryTable;
use Themightysapien\MediaLibrary\Traits\InteractsWithMediaLibrary;

class TempModel extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, InteractsWithMediaLibrary;

    protected $fillable = ['name'];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(Config::get('mlibrary.table_name'));
    }


    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
              ->width(368)
              ->height(232)
              ->sharpen(10);
        $this->addMediaConversion('preview')
              ->width(600)
              ->height(800)
              ->sharpen(10);
    }
}

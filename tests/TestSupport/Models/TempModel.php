<?php

namespace Themightysapien\MediaLibrary\Tests\TestSupport\Models;

use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
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
}

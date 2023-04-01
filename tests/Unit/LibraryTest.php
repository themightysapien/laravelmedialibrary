<?php

namespace Themightysapien\Medialibrary\Tests\Unit;


use Tests\TestCase;
use Themightysapien\Medialibrary\Tests\MediaLibraryTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Models\TempLibrary;

class LibraryTest extends MediaLibraryTestCase
{
    /**
     * Test Model Exists
     */
    public function test_that_library_model_exists(): void
    {
        $path = \Themightysapien\Medialibrary\Models\Library::class;
        // dd($path);

        $this->assertTrue($path == 'Themightysapien\Medialibrary\Models\Library', 'Library File not loaded');
    }


    public function test_that_library_table_exists(): void
    {
        $table = Config::get('mlibrary.table_name');

        $this->assertTrue($table !== null, 'Did you run the migration?');

        // $columns = Schema::getColumnListing($table);

        // dd($columns);

        $this->assertTrue(Schema::hasTable($table), 'Did you run the migrations?');
    }


    public function test_library_model_interacts_with_media()
    {

        $model = new Library();

        $this->assertTrue(in_array(InteractsWithMedia::class, class_uses_recursive($model)), 'Library should use Interacts With Model trait from spatie..');
    }



}

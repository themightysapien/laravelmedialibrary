<?php

namespace Themightysapien\MediaLibrary\Tests\Unit;


use Mockery;
use Tests\TestCase;
use Mockery\MockInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;
use Themightysapien\MediaLibrary\MediaLibrary;
use Themightysapien\MediaLibrary\Models\Library;
use Themightysapien\MediaLibrary\Models\TempLibrary;
use Themightysapien\MediaLibrary\Tests\MediaLibraryTestCase;
use Themightysapien\MediaLibrary\Facades\MediaLibrary as FacadesMediaLibrary;

class LibraryTest extends MediaLibraryTestCase
{
    /**
     * Test Model Exists
     */
    public function test_that_library_model_exists(): void
    {
        $path = \Themightysapien\MediaLibrary\Models\Library::class;
        // dd($path);

        $this->assertTrue($path == 'Themightysapien\MediaLibrary\Models\Library', 'Library File not loaded');
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


    public function test_config_has_filters_array()
    {
        $this->assertNotNull(Config::get('mlibrary.filters'), 'Forgot to add filters to config');

        $this->assertTrue(is_array(Config::get('mlibrary.filters')) && count(Config::get('mlibrary.filters')) > 0, 'Filter has no items.');
    }


    public function test_facade_is_working(){
        $this->instance(
            'themightysapienmedialibrary',
            Mockery::mock(MediaLibrary::class, function (MockInterface $mock) {
                $mock->shouldReceive('init')->once()->andReturn('test');
            })
        );

        $this->assertEquals('test', FacadesMediaLibrary::init());
    }
}

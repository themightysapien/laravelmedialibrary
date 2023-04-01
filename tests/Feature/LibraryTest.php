<?php

namespace Themightysapien\Medialibrary\Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;


use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Themightysapien\Medialibrary\Tests\TestSupport\Models\TempModel;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Tests\MediaLibraryTestCase;

class LibraryTest extends MediaLibraryTestCase
{

    use LazilyRefreshDatabase;

    public function test_file_upload_with_library()
    {

        $file = 'test.txt';
        Storage::disk(Config::get('media-library.disk_name'))->put($file, 'Hello world!!');

        $tempModel = TempModel::firstOrCreate(['name' => 'Temp']);
        // dump($tempModel);
        $tempModel
            ->addMediaByAddingToLibrary(Storage::disk(Config::get('media-library.disk_name'))->path($file))
            ->toMediaCollection();


        /* Check the library file exists */
        $this->assertDatabaseHas('media', [
            'collection_name' => Config::get('mlibrary.collection_name'),
            'model_type' => Library::class
        ]);

        /* Check model file exists */
        $this->assertDatabaseHas('media', [
            'collection_name' => 'default',
            'model_type' => TempModel::class
        ]);

        // $library = Medialibrary::init();

        // $tempModel->addMediaFromLibrary($library->media()->latest()->first())->toMediaCollection();

        // $this->assertDatabaseCount('media', 3);

        // $this->
    }
}

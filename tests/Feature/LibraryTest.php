<?php

namespace Themightysapien\Medialibrary\Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;


use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Facades\Medialibrary;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Themightysapien\Medialibrary\Tests\MediaLibraryTestCase;
use Themightysapien\Medialibrary\Tests\TestSupport\Models\TempModel;

class LibraryTest extends MediaLibraryTestCase
{

    use LazilyRefreshDatabase;

    private $files = [
        'test.txt' => 'Hello world',
        'test.json' => '[{"hello":"world"}]'

    ];

    public function setUpUploads($files)
    {
        $tempModel = TempModel::firstOrCreate(['name' => 'Temp']);

        foreach($files as $file => $content){
            Storage::disk(Config::get('media-library.disk_name'))->put($file, $content);


            $tempModel
                ->addMediaThroughLibrary(Storage::disk(Config::get('media-library.disk_name'))->path($file))
                ->toMediaCollection();
        }

        // dump($tempModel);
    }

    public function test_file_upload_with_library()
    {


        $this->setUpUploads($this->files);

        $this->assertTrue(Medialibrary::open()->media->count() == count($this->files));

        /* Check the library file exists */
        $this->assertDatabaseHas('media', [
            'collection_name' => Config::get('mlibrary.collection_name'),
            'model_type' => Library::class,
            'file_name' => 'test.json'
        ]);

        /* Check model file exists */
        $this->assertDatabaseHas('media', [
            'collection_name' => 'default',
            'model_type' => TempModel::class,
            'file_name' => 'test.json'
        ]);

        // $library = Medialibrary::init();

        // $tempModel->addMediaFromLibrary($library->media()->latest()->first())->toMediaCollection();

        // $this->assertDatabaseCount('media', 3);

        // $this->
    }


    public function test_route_works(){
        $response = $this->get(route('themightysapien.medialibrary.index'));
        // dump($response);

        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_route_returns_media_items(){
        $response = $this->json('get', route('themightysapien.medialibrary.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'items' => [
                        '*' => [
                            'id',
                            'name',

                        ]
                    ]
                ]
            );


    }
}

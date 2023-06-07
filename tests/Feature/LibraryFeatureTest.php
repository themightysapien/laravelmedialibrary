<?php

namespace Themightysapien\MediaLibrary\Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Themightysapien\MediaLibrary\Models\Library;
use Themightysapien\MediaLibrary\Facades\MediaLibrary;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Themightysapien\MediaLibrary\Tests\MediaLibraryTestCase;
use Themightysapien\MediaLibrary\Tests\TestSupport\Models\TempModel;

class LibraryFeatureTest extends MediaLibraryTestCase
{

    use LazilyRefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // dd($this->user);

        // auth()->login($this->user);
    }

    private $files = [
        'test.txt' => 'Hello world',
        'file.json' => '[{"hello":"world"}]'
    ];

    public function setUpUploads($files)
    {
        if (!isset($files['image.png'])) {
            $files['image.png'] = file_get_contents('https://dummyimage.com/600x400/000/fff');
            $this->files = $files;
        }
        // dump($this->files);
        MediaLibrary::open($this->user->id);
        $tempModel = TempModel::firstOrCreate(['name' => 'Temp', 'user_id' => $this->user->id]);

        foreach ($files as $file => $content) {
            Storage::disk(Config::get('media-library.disk_name'))->put($file, $content);



            $media = $tempModel
                ->addMediaThroughLibrary(Storage::disk(Config::get('media-library.disk_name'))->path($file), $this->user->id)
                ->toMediaCollection();
        }
        // dump($media);
    }

    public function test_file_upload_with_library()
    {

        // dump();


        $this->setUpUploads($this->files);

        $this->assertTrue(MediaLibrary::allMedia($this->user->id)->count() == count($this->files));

        /* Check the library record exists */
        $this->assertDatabaseHas('media', [
            'collection_name' => Config::get('mlibrary.collection_name', 'library'),
            'model_type' => Library::class,
            'file_name' => 'test.txt'
        ]);

        /* Check model record exists */
        $this->assertDatabaseHas('media', [
            'collection_name' => 'default',
            'model_type' => TempModel::class,
            'file_name' => 'file.json'
        ]);
    }

    public function test_library_files_can_be_reused()
    {
        $this->setUpUploads($this->files);

        /* check initally library has correct number of files */
        $this->assertTrue(MediaLibrary::allMedia($this->user->id)->count() == count($this->files));

        $tempModel = TempModel::firstOrCreate(['name' => 'Temp 2', 'user_id' => $this->user->id]);

        /* attach same file 4 times from library to model */
        for ($i = 1; $i <= 4; $i++) {
            $tempModel->addMediaFromLibrary(MediaLibrary::allMedia($this->user->id)[0])->toMediaCollection();
        }
        /* check library file still exists */
        $this->assertTrue(file_exists(MediaLibrary::allMedia($this->user->id)[0]->getPath()));

        /* check again library has correct number of files */
        $this->assertTrue(MediaLibrary::allMedia($this->user->id)->count() == count($this->files));

        /* check temp model media count is correct */
        $this->assertTrue($tempModel->media()->count() == 4, 'Temp model file count didnot match the upload');
    }


    public function test_all_media_facade_method()
    {
        $this->setUpUploads($this->files);

        $this->assertEquals(MediaLibrary::allMedia($this->user->id)->pluck('id')->toArray(), MediaLibrary::allMedia($this->user->id)->pluck('id')->toArray());

        $this->assertTrue(MediaLibrary::query($this->user->id) instanceof Builder);
    }


    public function test_route_works()
    {
        auth()->login($this->user);

        $response = $this->get(route('themightysapien.medialibrary.index'));
        // dd($response);


        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_route_returns_media_items()
    {
        $this->setUpUploads($this->files);
        auth()->login($this->user);
        $response = $this->json('get', route('themightysapien.medialibrary.index'));
        // dump($response['items']);
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

    public function test_route_returns_filtered_media_items_by_name()
    {
        $this->setUpUploads($this->files);
        auth()->login($this->user);

        $response = $this->json('get', route('themightysapien.medialibrary.index'), [
            'name' => 'test'
        ]);

        // dump($response['items']);

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

        $this->assertTrue(count($response['items']) == 1);
        $this->assertTrue(strpos($response['items'][0]['file_name'], 'test') !== false);
    }


    public function test_route_returns_filtered_media_items_by_type()
    {
        $this->setUpUploads($this->files);
        auth()->login($this->user);

        $response = $this->json('get', route('themightysapien.medialibrary.index'), [
            'type' => 'json'
        ]);

        // dump($response);

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

        $this->assertTrue(count($response['items']) == 1);
        // dump(strpos($response['items'][0]['mime_type'], 'json'));

        $this->assertTrue(strpos($response['items'][0]['mime_type'], 'json') !== false);
    }

    public function test_route_returns_thumb_url_for_image()
    {
        $this->setUpUploads($this->files);
        auth()->login($this->user);

        $response = $this->json('get', route('themightysapien.medialibrary.index'), [
            'type' => 'image'
        ]);

        // dump($response);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [
                    'items' => [
                        '*' => [
                            'id',
                            'name',
                            'thumb_url'
                        ]
                    ]
                ]
            );



        $this->assertTrue(strpos($response['items'][0]['mime_type'], 'image') !== false);
    }


    public function test_route_returns_default_sorted_records()
    {
        $this->setUpUploads($this->files);

        $media = MediaLibrary::allMedia($this->user->id);
        // dump($media);
        auth()->login($this->user);

        $response = $this->json('get', route('themightysapien.medialibrary.index'), [
            'sort_by' => 'id',
            'sort_type' => 'DESC'
        ]);



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

        /* check last item is the first item in response */
        $this->assertTrue($media[count($media) - 1]->id == $response['items'][0]['id']);
    }
}

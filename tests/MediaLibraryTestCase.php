<?php

namespace Themightysapien\MediaLibrary\Tests;

use Tests\TestCase;
use Illuminate\Support\Facades\File;

class MediaLibraryTestCase extends TestCase
{

    protected function setUp(): void
    {


        parent::setUp();
        $this->getEnvironmentSetUp($this->app);


        $this->setUpTempTestFiles();
    }

    public function getEnvironmentSetUp($app)
    {
        $this->initializeDirectory($this->getTempDirectory());


        config()->set('filesystems.disks.public', [
            'driver' => 'local',
            'root' => $this->getMediaDirectory(),
            'url' => '/media',
        ]);

        config()->set('filesystems.disks.secondMediaDisk', [
            'driver' => 'local',
            'root' => $this->getTempDirectory('media2'),
            'url' => '/media2',
        ]);

        $app->bind('path.public', fn () => $this->getTempDirectory());

        config()->set('media-library.disk_name', 'public');
    }

    // use CreatesApplication;
    protected function setUpTempTestFiles()
    {
        $this->initializeDirectory($this->getTestFilesDirectory());
        File::copyDirectory(__DIR__ . '/TestSupport/testfiles', $this->getTestFilesDirectory());
    }

    protected function initializeDirectory($directory)
    {
        if (File::isDirectory($directory)) {
            File::deleteDirectory($directory);
        }
        File::makeDirectory($directory);
    }

    public function getTestsPath($suffix = ''): string
    {
        if ($suffix !== '') {
            $suffix = "/{$suffix}";
        }

        return __DIR__ . $suffix;
    }

    public function getTempDirectory(string $suffix = ''): string
    {
        return __DIR__ . '/TestSupport/temp' . ($suffix == '' ? '' : '/' . $suffix);
    }

    public function getMediaDirectory(string $suffix = ''): string
    {
        return $this->getTempDirectory() . '/media' . ($suffix == '' ? '' : '/' . $suffix);
    }

    public function getTestFilesDirectory(string $suffix = ''): string
    {
        return $this->getTempDirectory() . '/testfiles' . ($suffix == '' ? '' : '/' . $suffix);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        File::deleteDirectory($this->getTempDirectory());
    }
}

# Reusable Library for Spatie Media Library

[![Latest Version on Packagist](https://img.shields.io/packagist/v/themightysapien/medialibrary.svg?style=flat-square)](https://packagist.org/packages/themightysapien/medialibrary)
[![Total Downloads](https://img.shields.io/packagist/dt/themightysapien/medialibrary.svg?style=flat-square)](https://packagist.org/packages/themightysapien/medialibrary)
![GitHub Actions](https://github.com/themightysapien/medialibrary/actions/workflows/main.yml/badge.svg)

This packages adds a reusable library functionality on top of [Spatie Media Library](https://spatie.be/docs/laravel-medialibrary/v9/introduction) package. 

### Features

- Add media to library
- Use media from library
- Add media through library
- Clear library

## Installation

You can install the package via composer:

```bash
composer require themightysapien/medialibrary
# publish config and migrations
php artisan vendor:publish --provider="Themightysapien\MediaLibrary\MediaLibraryServiceProvider" --tag="config" --tag="migrations"
# Check config files for any modifications then run
php artisan migrate
```

## Prepare Your Model
Just add ```InteractsWithMediaLibrary``` trait on top of spatie's model setup.
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Themightysapien\MediaLibrary\Traits\InteractsWithMediaLibrary;

class YourModel extends Model implements HasMedia
{
    use InteractsWithMedia;
    use InteractsWithMediaLibrary;
}
```
## Usage
#### Add Media to library
```php
use Themightysapien\MediaLibrary\Facades\MediaLibrary;

$media = MediaLibrary::open()->addMedia($file);
```
#### Associate file for model through library.
This will first add the file to library and then associate media to the model.
```php
$model->addMediaThroughLibrary($file)
// chain through any spatie's File Adder functions
->toMediaCollection();
```
#### Associate library media for model.
```php
$model->addMediaFromLibrary($media)
// chain through any spatie's File Adder functions
->toMediaCollection();
```
#### Clear Library
```php
use Themightysapien\MediaLibrary\Facades\MediaLibrary;

MediaLibrary::open()->clear();
```
#### Get library media collection
```php
use Themightysapien\MediaLibrary\Facades\MediaLibrary;

// All Media
MediaLibrary::open()->getMedia()

// Builder
MediaLibrary::open()->media()->limit(5)->lastest()->get()
```
#### Get library media collection through api
```php
$response = $this->json('GET', '{PREFIX_FROM_CONFIG}/tsmedialibrary', [
    'name' => 'document', // matches file and name with document
    'type' => 'pdf', //matches mime type with pdf
    'sort_by' => 'created_at',
    'sort_type' => 'DESC',
    'per_page' => 10 // default set on config
]);

['items' => $mediaCollection, 'pagination' => $pagination] = $response;
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email themightysapien@gmail.com instead of using the issue tracker.

## Credits

-   [Anup Pokharel](https://github.com/themightysapien)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

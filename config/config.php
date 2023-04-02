<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'table_name' => 'media_library',
    'collection_name' => 'library',
    'route_prefix' => '/api/medialibrary',
    'route_middleware' => ['api'],
    'filters' => [
        \Themightysapien\Medialibrary\Filters\FileNameFilter::class,
        \Themightysapien\Medialibrary\Filters\FileTypeFilter::class,
        \Themightysapien\Medialibrary\Filters\DefaultSortFilter::class,
    ],
    'items_per_page' => 50
];

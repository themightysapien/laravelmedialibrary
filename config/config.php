<?php
return [
    /* library table name */
    'table_name' => 'media_library',
    /* library media collection name */
    'collection_name' => 'library',
    /* api route prefix */
    'route_prefix' => '/v1/',
    /* api route middleware */
    'route_middleware' => ['web', 'auth'],
    /* resource path */
    'route_resource' => '/tsmedialibrary',
    /* listing filters */
    'filters' => [
        \Themightysapien\MediaLibrary\Filters\FileNameFilter::class,
        \Themightysapien\MediaLibrary\Filters\FileTypeFilter::class,
        \Themightysapien\MediaLibrary\Filters\DefaultSortFilter::class,
    ],
    /* api list pagination  */
    'items_per_page' => 50,
    /* library conversion */
    'thumbnail' => [
        'width' => 250,
        'height' => 250,
    ],
    'validations' => [
        'image' => 'image',
        'file' => 'mimes:jpg,png,gif,jpeg,pdf,xml,csv,pdf,doc,docx'
    ]
];

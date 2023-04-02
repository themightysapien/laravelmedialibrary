<?php

namespace Themightysapien\Medialibrary\Process;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Config;
use Themightysapien\Medialibrary\Contracts\ProcessContract;
use Themightysapien\Medialibrary\Contracts\PayloadContract;
use Themightysapien\Medialibrary\Filters\OnlyLibraryMediaFilter;
use Themightysapien\Medialibrary\Payloads\LibraryMediaPayload;

class ListLibraryMediaProcess implements ProcessContract
{
    public function run(PayloadContract $payload)
    {
        return app(Pipeline::class)
            ->send($payload)
            ->through($this->tasks())
            // ->thenReturn();
            ->then(function (LibraryMediaPayload $payload) {
                return $payload
                    ->builder
                    ->paginate($payload->request()->get('per_page', Config::get('mlibrary.items_per_page', 50)));
            });
            /* ->thenReturn() */;
    }


    public function tasks()
    {
        return array_merge(
            [OnlyLibraryMediaFilter::class],
            Config::get('mlibrary.filters', []),

        );
    }
}

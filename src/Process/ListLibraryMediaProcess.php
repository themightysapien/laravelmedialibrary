<?php

namespace Themightysapien\MediaLibrary\Process;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Config;
use Themightysapien\MediaLibrary\Contracts\ProcessContract;
use Themightysapien\MediaLibrary\Contracts\PayloadContract;
use Themightysapien\MediaLibrary\Filters\OnlyLibraryMediaFilter;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;

class ListLibraryMediaProcess implements ProcessContract
{
    public function run(PayloadContract $payload)
    {
        return app(Pipeline::class)
            ->send($payload)
            ->through($this->tasks())
            // ->thenReturn();
            ->then(function (PayloadContract $payload) {
                // dump($payload->queryBuilder()->toSql());
                return $payload
                    ->queryBuilder()
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

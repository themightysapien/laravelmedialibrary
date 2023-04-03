<?php

namespace Themightysapien\MediaLibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\MediaLibrary\Models\Library;
use Themightysapien\MediaLibrary\Contracts\PayloadContract;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;
use Themightysapien\MediaLibrary\Contracts\ProcessTaskContract;

class OnlyLibraryMediaFilter implements ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next)
    {
        $payload->queryBuilder()->where('collection_name', Config::get('mlibrary.collection_name', 'library'))
            ->where('model_type', Library::class);

        return $next($payload);
    }
}

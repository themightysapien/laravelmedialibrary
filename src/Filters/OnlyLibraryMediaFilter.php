<?php

namespace Themightysapien\Medialibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Contracts\PayloadContract;
use Themightysapien\Medialibrary\Payloads\LibraryMediaPayload;
use Themightysapien\Medialibrary\Contracts\ProcessTaskContract;

class OnlyLibraryMediaFilter implements ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next)
    {
        $payload->queryBuilder()->where('collection_name', Config::get('mlibrary.collection_name', 'library'))
            ->where('model_type', Library::class);

        return $next($payload);
    }
}

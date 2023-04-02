<?php

namespace Themightysapien\Medialibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Contracts\PayloadContract;
use Themightysapien\Medialibrary\Contracts\ProcessTaskContract;
use Themightysapien\Medialibrary\Payloads\LibraryMediaPayload;

class DefaultSortFilter implements ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next)
    {
        $payload->queryBuilder()->orderBy($payload->request()->get('sort_by', 'created_at'), $payload->request()->get('sort_type', 'DESC'));

        return $next($payload);
    }
}

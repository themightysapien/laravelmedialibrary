<?php

namespace Themightysapien\MediaLibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\MediaLibrary\Models\Library;
use Themightysapien\MediaLibrary\Contracts\PayloadContract;
use Themightysapien\MediaLibrary\Contracts\ProcessTaskContract;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;

class DefaultSortFilter implements ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next)
    {
        $payload->queryBuilder()->orderBy($payload->request()->get('sort_by', 'created_at'), $payload->request()->get('sort_type', 'DESC'));

        return $next($payload);
    }
}

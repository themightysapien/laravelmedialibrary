<?php

namespace Themightysapien\Medialibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Contracts\PayloadContract;
use Themightysapien\Medialibrary\Contracts\ProcessTaskContract;
use Themightysapien\Medialibrary\Payloads\LibraryMediaPayload;

class FileTypeFilter implements ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next)
    {
        $payload->queryBuilder()->when($payload->request()->get('type'), function ($query) use ($payload) {
            $query->where('mime_type', 'LIKE', "%{$payload->request()->get('type')}%");
        });

        return $next($payload);
    }
}

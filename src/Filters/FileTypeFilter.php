<?php

namespace Themightysapien\MediaLibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\MediaLibrary\Models\Library;
use Themightysapien\MediaLibrary\Contracts\PayloadContract;
use Themightysapien\MediaLibrary\Contracts\ProcessTaskContract;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;

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

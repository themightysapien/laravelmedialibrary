<?php

namespace Themightysapien\Medialibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\Medialibrary\Models\Library;
use Themightysapien\Medialibrary\Contracts\PayloadContract;
use Themightysapien\Medialibrary\Contracts\ProcessTaskContract;
use Themightysapien\Medialibrary\Payloads\LibraryMediaPayload;

class FileNameFilter implements ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next)
    {
        $payload->queryBuilder()->when($payload->request()->get('name'), function ($query) use ($payload) {
            $query->where(function ($q) use ($payload) {
                $q
                    ->orWhere('name', 'LIKE', "%{$payload->request()->get('name')}%")
                    ->orWhere('file_name', 'LIKE', "%{$payload->request()->get('name')}%");
            });
        });

        return $next($payload);
    }
}

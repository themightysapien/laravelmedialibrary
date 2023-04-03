<?php

namespace Themightysapien\MediaLibrary\Filters;

use Closure;
use Illuminate\Support\Facades\Config;
use Themightysapien\MediaLibrary\Models\Library;
use Themightysapien\MediaLibrary\Contracts\PayloadContract;
use Themightysapien\MediaLibrary\Contracts\ProcessTaskContract;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;

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

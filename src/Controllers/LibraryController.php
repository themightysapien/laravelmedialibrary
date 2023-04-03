<?php

namespace Themightysapien\MediaLibrary\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Themightysapien\MediaLibrary\Resources\MediaResource;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;
use Themightysapien\MediaLibrary\Process\ListLibraryMediaProcess;

class LibraryController
{

    public function index(Request $request, ListLibraryMediaProcess $process)
    {

        $items = $process->run(new LibraryMediaPayload(
            builder: Media::query(),
            request: $request
        ));

        // dump(get_class($items));


        return response()->json([
            'items' => MediaResource::collection($items),
            'pagination' => $this->extractPagination($items)
        ]);
    }

    private function extractPagination(Paginator $paginator)
    {
        return [
            'total' => $paginator->total(),
            'per_page' => min($paginator->total(), $paginator->perPage()),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'links' => [
                'first_url' => $paginator->url(1),
                'last_url' => $paginator->url($paginator->lastPage()),
                'next_url' => $paginator->nextPageUrl(),
                'previous_url' => $paginator->previousPageUrl(),
                'path_url' => url('api/v1')
            ],
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem()
        ];
    }
}

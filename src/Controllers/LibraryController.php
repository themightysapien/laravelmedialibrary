<?php

namespace Themightysapien\MediaLibrary\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Contracts\Pagination\Paginator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Themightysapien\MediaLibrary\Facades\MediaLibrary;
use Themightysapien\MediaLibrary\Resources\MediaResource;
use Themightysapien\MediaLibrary\Payloads\LibraryMediaPayload;
use Themightysapien\MediaLibrary\Process\ListLibraryMediaProcess;

class LibraryController
{
    use ValidatesRequests;

    public function index(Request $request, ListLibraryMediaProcess $process)
    {

        $items = $process->run(new LibraryMediaPayload(
            builder: Media::query(),
            request: $request
        ));
        // dump(request()->url());

        return response()->json([
            'items' => MediaResource::collection($items),
            'pagination' => $this->extractPagination($items)
        ]);
    }

    public function store(Request $request)
    {
        /* select correct rules */
        $rules = Config::get('mlibrary.validations.image', 'image');
        if ($request->allow_files) {
            $rules = Config::get('mlibrary.validations.file', 'jpg,png,gif,jpeg,pdf');
        }
        // return ($rules);
        /* validate */
        $this->validate($request, [
            'files.*' => 'required|' . $rules
        ], [
            'files.*.mimes' => $request->allow_files ? 'Cannot accept uploaded file type.' : 'Upload file must be an image'
        ]);

        $attachments = [];

        foreach ($request->file('files') as $file) {
            $attachments[] = MediaLibrary::addMedia($file);
        }


        return response()->json([
            'items' => MediaResource::collection($attachments)
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

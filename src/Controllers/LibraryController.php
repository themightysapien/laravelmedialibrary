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

    /*
    Return Paginated Media Collection
    */
    public function index(Request $request, ListLibraryMediaProcess $process)
    {

        $items = $process->run(new LibraryMediaPayload(
            builder: Media::query(),
            request: $request
        ));
        // dump(request()->url());

        return apiSuccessResponse([
            'items' => MediaResource::collection($items),
            'pagination' => extractPaginationArray($items)
        ]);
    }

    /*
    Add Media to Library
    */
    public function store(Request $request)
    {
        /* select correct rules */
        $rules = Config::get('mlibrary.validations.image', 'image');
        if ($request->allow_files) {
            $rules = Config::get('mlibrary.validations.file', 'jpg,png,gif,jpeg,pdf');
        }

        /* validate */
        $this->validate($request, [
            'files.*' => 'required|' . $rules
        ], [
            'files.*.image' => 'Uploaded file must be an image',
            'files.*.mimes' => 'Cannot accept uploaded file type.'
        ]);


        /* add media and store in array */
        $attachments = [];

        foreach ($request->file('files') as $file) {
            $attachments[] = MediaLibrary::addMedia($file);
        }


        return apiSuccessResponse([
            'items' => MediaResource::collection($attachments)
        ]);
    }


    /*
    Remove a media by id
     */
    public function destroy($id)
    {
        abort(404);
        $media = MediaLibrary::query()->where('id', $id)->first();

        if ($media) {
            $media->delete();
        }

        return apiSuccessResponse([], 'Deleted');
    }
}

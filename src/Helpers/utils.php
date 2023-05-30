<?php
if (!function_exists('extractPaginationArray')) :
    function extractPaginationArray(\Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator)
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
endif;

if (!function_exists('apiSuccessResponse')) :
    function apiSuccessResponse($data = [], $message = '')
    {
        return response()->json(array_merge($data, [
            'success' => 1,
            'message' => $message
        ]));
    }
endif;

if (!function_exists('apiErrorResponse')) :
    function apiErrorResponse($message = '', $data = [])
    {
        return response()->json(array_merge($data, [
            'error' => 1,
            'message' => $message
        ]));
    }
endif;

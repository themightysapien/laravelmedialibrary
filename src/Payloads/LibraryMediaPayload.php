<?php

namespace Themightysapien\Medialibrary\Payloads;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Themightysapien\Medialibrary\Contracts\PayloadContract;

class  LibraryMediaPayload implements PayloadContract
{

    public function __construct(public Builder $builder, public Request $request)
    {
    }

    public function queryBuilder(): Builder
    {
        return $this->builder;
    }

    public function request(): Request
    {
        return $this->request;
    }
}

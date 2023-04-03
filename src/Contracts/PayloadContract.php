<?php

namespace Themightysapien\MediaLibrary\Contracts;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

interface PayloadContract
{

    public function queryBuilder(): Builder;

    public function request(): Request;
}

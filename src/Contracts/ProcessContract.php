<?php

namespace Themightysapien\Medialibrary\Contracts;

use Closure;

interface  ProcessContract
{
    public function run(PayloadContract $payload);
}

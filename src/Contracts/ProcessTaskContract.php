<?php

namespace Themightysapien\Medialibrary\Contracts;

use Closure;
use Themightysapien\Medialibrary\Contracts\PayloadContract;

interface  ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next);
}

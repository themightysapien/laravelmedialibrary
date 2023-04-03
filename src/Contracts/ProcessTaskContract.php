<?php

namespace Themightysapien\MediaLibrary\Contracts;

use Closure;
use Themightysapien\MediaLibrary\Contracts\PayloadContract;

interface  ProcessTaskContract
{
    public function __invoke(PayloadContract $payload, Closure $next);
}

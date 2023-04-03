<?php

namespace Themightysapien\MediaLibrary\Contracts;

use Closure;

interface  ProcessContract
{
    public function run(PayloadContract $payload);
}

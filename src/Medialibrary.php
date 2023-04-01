<?php

namespace Themightysapien\Medialibrary;

use Themightysapien\Medialibrary\Models\Library;

class Medialibrary
{
    public function init(){
        return Library::firstOrNew([]);
    }
}

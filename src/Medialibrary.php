<?php

namespace Themightysapien\Medialibrary;

use Themightysapien\Medialibrary\Models\Library;

class Medialibrary
{
    public function init()
    {
        return Library::firstOrNew([]);
    }

    public function open(){
        return $this->init();
    }

    public function clear()
    {
        return $this->init()->clearCollection();
    }
}

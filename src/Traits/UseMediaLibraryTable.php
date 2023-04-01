<?php

namespace Themightysapien\Medialibrary\Traits;

use Illuminate\Support\Facades\Config;

trait UseMediaLibraryTable
{

    protected function newRelatedInstance($class)
    {
        return tap((new $class())->setTable(Config::get('mlibrary.table_name')), function ($instance) {
            if (!$instance->getConnectionName()) {
                $instance->setConnection($this->connection);
            }
        });
    }

    public function newInstance($attributes = [], $exists = false): static
    {
        return parent::newInstance($attributes, $exists)->setTable(Config::get('mlibrary.table_name'));
    }
}

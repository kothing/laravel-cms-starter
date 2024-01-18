<?php

namespace Star\DataTables\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Star\DataTables\DataTables
 *
 * @method static \Star\DataTables\EloquentDatatable eloquent($builder)
 * @method static \Star\DataTables\QueryDataTable query($builder)
 * @method static \Star\DataTables\CollectionDataTable collection($collection)
 *
 * @see \Star\DataTables\DataTables
 */
class DataTables extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'datatables';
    }
}

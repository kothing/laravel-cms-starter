<?php

if (! function_exists('datatables')) {
    /**
     * Helper to make a new DataTable instance from source.
     * Or return the factory if source is not set.
     *
     * @param  \Illuminate\Contracts\Database\Query\Builder|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Support\Collection|array|null  $source
     * @return \Star\DataTables\DataTables|\Star\DataTables\DataTableAbstract
     *
     * @throws \Star\DataTables\Exceptions\Exception
     */
    function datatables($source = null)
    {
        /** @var Star\DataTables\DataTables $dataTable */
        $dataTable = app('datatables');

        if (is_null($source)) {
            return $dataTable;
        }

        return $dataTable->make($source);
    }
}

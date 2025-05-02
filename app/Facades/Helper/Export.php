<?php

namespace App\Facades\Helper;

class Export
{
    public function excel($model, $table)
    {
        return (new $model())->download($table . '.xlsx');
    }
    public function csv($model, $table)
    {
        return ((new $model())->download($table . '.csv'));
    }
    public function tsv($model, $table)
    {
        return (new $model())->download($table . '.tsv');
    }
    public function ods($model, $table)
    {
        return (new $model())->download($table . '.ods');
    }
    public function xls($model, $table)
    {
        return (new $model())->download($table . '.xls');
    }
    public function html($model, $table)
    {
        return (new $model())->download($table . '.html');
    }
    public function pdf($model, $table)
    {
        return (new $model())->download($table . '.pdf');
    }
}

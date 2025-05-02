<?php

namespace App\Facades\Helper;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class Import
{
    public function store(Request $request, $model)
    {
        try {
            if ($request->hasFile('file')) {
                $import = new $model();
                $import->import($request->file('file'));
                return trans('messages.data_imported');
            }
            return response()->json(trans('messages.invalid_data'), Config('constants.STATUS_CODE.BAD_REQUEST'));
        } catch (ValidationException $e) {
            return response()->json($e->failures(), Config('constants.STATUS_CODE.UNPROCESSABLE_ENTITY'));
        }
    }
}

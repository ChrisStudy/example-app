<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportOffices;

class ImportController extends Controller
{
    public function importFile()
    {
       return view('import');
    }

    public function import() 
    {
        Excel::import(new ImportOffices, request()->file('file'));
            
        return back();
    }
}

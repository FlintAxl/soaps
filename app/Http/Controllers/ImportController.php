<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ImportController extends Controller
{
    public function show()
    {
        return view('products.import');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('products.index')->with('success', 'Products imported successfully!');
    }
}

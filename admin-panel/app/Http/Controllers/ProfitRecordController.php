<?php

namespace App\Http\Controllers;

use App\Models\ProfitRecord;
use Illuminate\Http\Request;

class ProfitRecordController extends Controller
{
    // Index page
    public function index()
    {
        $records = ProfitRecord::with(['saleItem', 'product'])
                    ->orderBy('id', 'desc')
                    ->paginate(20);

        return view('pages.profit_records.index', compact('records'));
    }

    // Show single record
    public function show($id)
    {
        $profitRecord = ProfitRecord::with(['saleItem', 'product'])->findOrFail($id);

        return view('pages.profit_records.show', compact('profitRecord'));
    }
}

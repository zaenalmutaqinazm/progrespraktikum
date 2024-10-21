<?php

namespace App\Http\Controllers;

use App\Models\Supplier; 
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function create()
    {
        return view("master-data.supplier-master.create-supplier");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string|max:255',
            'supplier_address' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'comment' => 'nullable|string|max:500',
        ]);

        Supplier::create($validated);

        return redirect()->back()->with('success', 'Supplier created successfully!');
    }
}

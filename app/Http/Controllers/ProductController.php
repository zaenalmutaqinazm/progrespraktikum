<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Pest\Arch\Options\LayerOptions;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // return view('layouts-percobaan.app');
        return view('product', [
            'isi_data' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("master-data.product-master.create-product");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validasi_data = $request->validate([
            'product_name'=>'required|string|max:255',
            'unit'=>'required|string|max:50',
            'type'=>'required|string|max:50',
            'information'=>'nullable|string|',
            'qty'=>'required|integer',
            'producer'=>'required|string|max:255',
        ]);
        
        product::create($validasi_data);

        return redirect()->back()->with('success', 'Product created succesfully!');
        // try {
        //     Product::create($validasi_data);
        //     return redirect()->back()->with('success', 'Product created successfully!');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

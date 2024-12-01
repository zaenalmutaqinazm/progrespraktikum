<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Pest\Arch\Options\LayerOptions;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
    
    public function exportToPdf()
    {
        // Ambil semua data produk
        $products = Product::all();
        // Render ke template PDF
        $pdf = Pdf::loadView('master-data.product-master.product-pdf', compact('products'));
    
        // Download file PDF
        return $pdf->download('products.pdf');
    }
    public function index()
    {
        $data = Product::all();
        return view('master-data.product-master.index-product', compact('data'));
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
        $product = Product::findOrFail($id);
    return view('master-data.product-master.product-detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view("master-data.product-master.edit-product", compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string',
            'type' => 'required|string|max:255',
            'information' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'producer' => 'required|string|max:255',
        ]);
    
        // Mengupdate data produk
        $product = Product::findOrFail($id);
        $product->product_name = $request->input('product_name');
        $product->unit = $request->input('unit');
        $product->type = $request->input('type');
        $product->information = $request->input('information');
        $product->qty = $request->input('qty');
        $product->producer = $request->input('producer');
        
        $product->save();
        return redirect()->route('product-index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->route('product-index')->with('success', 'Product berhasil dihapus.');
        }
        return redirect()->route('product-index')->with('error', 'Product tidak ditemukan.');
    }
}

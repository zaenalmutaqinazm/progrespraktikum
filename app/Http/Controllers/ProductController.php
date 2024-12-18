<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Supplier;
use Pest\Arch\Options\LayerOptions;

class ProductController extends Controller
{
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
    public function index(request $request)
    {
        // Membuat query builder baru untuk model Product
        $query = Product::with('supplier'); 

        // Cek apakah ada parameter 'search' di request
        if ($request->has('search') && $request->search != '') {

            // Melakukan pencarian berdasarkan nama produk atau informasi
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%');
            });
        }

        $products = $query->paginate(2);

        return view('master-data.product-master.index-product', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('master-data.product-master.create-product', compact('suppliers'));
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
            'supplier_id' => 'required|exists:suppliers,id'
        ]);
        
        Product::create($validasi_data);

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
        $suppliers = Supplier::all();
        return view('master-data.product-master.edit-product', compact('product', 'suppliers'));
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
            'supplier_id' => 'nullable|exists:suppliers,id', 
        ]);
    
        // Mengupdate data produk
        $product = Product::findOrFail($id);
        $product->product_name = $request->input('product_name');
        $product->unit = $request->input('unit');
        $product->type = $request->input('type');
        $product->information = $request->input('information');
        $product->qty = $request->input('qty');
        $product->producer = $request->input('producer');
        $product->supplier_id = $request->input('supplier_id'); 
        
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

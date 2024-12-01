<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product Detail') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <!-- Tampilkan ID Produk -->
            <p><strong>Product ID:</strong> {{ $product->id }}</p>
            
            <!-- Tampilkan Nama Produk -->
            <h3 class="text-2xl font-semibold mb-4">{{ $product->product_name }}</h3>
            
            <!-- Tampilkan Detail Produk -->
            <p><strong>Unit:</strong> {{ $product->unit }}</p>
            <p><strong>Type:</strong> {{ $product->type }}</p>
            <p><strong>Information:</strong> {{ $product->information }}</p>
            <p><strong>Quantity:</strong> {{ $product->qty }}</p>
            <p><strong>Producer:</strong> {{ $product->producer }}</p>

            <!-- Tombol Edit dan Back Berdampingan dengan Ukuran yang Sama -->
            <div class="mt-6 flex space-x-4">
                <!-- Tombol Edit Product -->
                <a href="{{ route('product-edit', $product->id) }}" class="inline-block w-1/2 px-6 py-3 text-green bg-green-200 border border-green-600 rounded-lg shadow-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Edit 
                </a>

                <!-- Tombol Back to Product List -->
                <a href="{{ route('product-index') }}" class="inline-block w-1/2 px-6 py-3 text-blue bg-blue-600 border border-blue-2s00 rounded-lg shadow-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Back 
                </a>
            </div>
        </div>
    </div>
</x-app-layout>


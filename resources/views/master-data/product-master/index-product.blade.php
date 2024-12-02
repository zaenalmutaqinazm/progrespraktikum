<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="container p-4 mx-auto">
    <div class="overflow-x-auto">
         @if(session('success'))
            <div class="p-4 mb-4 text-green-600 bg-green-200 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 text-red-600 bg-red-200 border border-red-300 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" action="{{ route('product-index') }}" class="mb-4 flex items-center">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
          <button type="submit" class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Cari</button>
          </form>
          
    
        <div class="flex space-x-6 mt-4">
          <!-- Tombol Add Product -->
          <a href="{{ route('product-create') }}">
              <button class="px-6 py-3 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                  Add Product
              </button>
          </a>
      
          <!-- Tombol Export to Excel -->
          <a href="{{ route('product-export-excel') }}">
              <button class="px-6 py-3 text-white bg-blue-500 border border-blue-500 rounded-lg shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                  Export to Excel
              </button>
          </a>
      
          <!-- Tombol Export to PDF -->
          <a href="{{ route('product-export-pdf') }}">
              <button class="px-6 py-3 text-white bg-red-500 border border-red-500 rounded-lg shadow-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                  Export to PDF
              </button>
          </a>
      </div>
      
      
  

      <table class="min-w-full border border-collapse border-gray-200 mt-4">
        <thead>
          <tr class="bg-gray-100">
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">ID</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Product Name</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Unit</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Type</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Information</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Qty</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Producer</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Supplier Name</th>
            <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Actions</th>
          </tr>
        </thead>
        <tbody>

  @forelse ($products as $product)
    <tr class="bg-white">
        <td class="px-4 py-2 border border-gray-200">{{ $loop->iteration }}</td>
        <!-- Nama Produk Dikaitkan dengan Rute Detail Produk -->
        <td class="px-4 py-2 border border-gray-200">
            <a href="{{ route('product-detail', $product->id) }}" class="text-blue-600 hover:text-blue-800">
                {{ $product->product_name }}
            </a>
        </td>
        <td class="px-4 py-2 border border-gray-200">{{ $product->unit }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ $product->type }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ $product->information }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ $product->qty }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ $product->producer }}</td>
        <td class="px-4 py-2 border border-gray-200">{{ $product->supplier->supplier_name ?? '-' }}</td>
        <td class="px-4 py-2 border border-gray-200">
            <a href="{{ route('product-edit', $product->id) }}" class="px-2 text-blue-600 hover:text-blue-800">Edit</a>
            <button class="px-2 text-red-600 hover:text-red-800" onclick="confirmDelete('{{ route('product-delete', $product->id) }}')">Hapus</button>
        </td>
    </tr>
    @empty
    <p class="mb-4 text-center text-2xl font-bold text-red-600">no product found</p>
@endforelse
  </table>
  <div class="mt-4">
      {{ $products->appends(['search' => request('search')])->links() }}
  </div>
</div>

  <script>
    function confirmDelete(deleteUrl) {
      if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        let csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
      }
    }
  </script>
</x-app-layout>

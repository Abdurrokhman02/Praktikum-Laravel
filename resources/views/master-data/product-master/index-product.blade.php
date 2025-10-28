<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="container p-4 mx-auto">
        <div class="overflow-x-auto">

            @if (session ('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-200 rounded-lg" role="alert" id="success-alert">
                {{ session('success') }}
            </div>
            @elseif (session ('error'))
            <div class="p-4 mb-4 text-red-800 bg-red-200 rounded-lg" role="alert" id="error-alert">
                {{ session('error') }}
            </div>
            @endif

            {{-- FORM PENCARIAN (Sudah ada hidden input sorting) --}}
            <form method="GET" action="{{ route('product-index') }}" class="mb-4 flex items-center">
                {{-- Input tersembunyi untuk sorting --}}
                <input type="hidden" name="sort_by" value="{{ $sortBy ?? 'id' }}">
                <input type="hidden" name="sort_dir" value="{{ $sortDir ?? 'asc' }}">

                <input type="text"
                name="search"
                value="{{request('search')}}"
                placeholder="Cari produk..." class="w-1/4 rounded-lg border border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="ml-2 rounded-lg bg-green-500 px-4 py-2 text-white shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">Cari</button>
            </form>
            
            <a href="{{ route('product-create')}}">
                <button class="px-6 py-4 mb-4 text-white bg-green-500 border border-green-500 rounded-lg shadow-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Add product data
                </button>
            </a>

            <table class="min-w-full border border-collapse border-gray-200">

                <thead>
                    <tr class="bg-gray-100">
                        {{-- FUNGSI SORTING (TUGAS 2) --}}
                        @php
                        function sort_link($label, $column, $currentSortBy, $currentSortDir, $searchQuery) {
                            $newSortDir = ($currentSortBy == $column && $currentSortDir == 'asc') ? 'desc' : 'asc';
                            $icon = '';
                            if ($currentSortBy == $column) {
                                $icon = ($currentSortDir == 'asc') ? ' &uarr;' : ' &darr;'; // Panah
                            }
                            $params = ['sort_by' => $column, 'sort_dir' => $newSortDir];
                            if ($searchQuery) {
                                $params['search'] = $searchQuery;
                            }
                            return '<a href="'.route('product-index', $params).'">'.$label.$icon.'</a>';
                        }
                        @endphp

                        {{-- HEADER TABEL DENGAN SORTING (TUGAS 2) --}}
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('ID', 'id', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('Product Name', 'product_name', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('Unit', 'unit', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('Type', 'type', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('information', 'information', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('qty', 'qty', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">{!! sort_link('producer', 'producer', $sortBy, $sortDir, request('search')) !!}</th>
                        <th class="px-4 py-2 text-left text-gray-600 border border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                    <tr class="bg-white">
                        <td class="px-4 py-2 border border-gray-200">{{ $item->id }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            <a href="{{ route('product-detail', $item->id) }}" class="text-blue-600 hover:underline">
                                {{ $item->product_name }}
                            </a>
                        </td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->unit }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->type }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ Str::limit($item->information, 30) }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->qty }}</td>
                        <td class="px-4 py-2 border border-gray-200">{{ $item->producer }}</td>
                        <td class="px-4 py-2 border border-gray-200">
                            <a href="{{ route('product-edit', $item->id) }}"
                                class="px-2 text-blue-600 hover:text-blue-800">Edit</a>
                            <button class="px-2 text-red-600 hover:text-red-800" onclick="confirmDelete('{{route('product-delete', $item->id)}}')">Hapus</button>
                        </td>
                    </tr>
                    @empty
                     <tr>
                         <td colspan="8" class="px-4 py-2 text-center text-red-600 border border-gray-200">No product found</td>
                     </tr>
                    @endforelse
                </tbody>
            </table>
            
            {{-- PAGINASI (Sudah ada appends sorting) --}}
            <div class="mt-4">
                {{ $data->appends(['search' => request('search'), 'sort_by' => $sortBy, 'sort_dir' => $sortDir])->links() }}
            </div>
        </div>
    </div>
    
    {{-- SCRIPT POP-UP (TUGAS 3) --}}
    <script>
        // Fungsi konfirmasi hapus
        function confirmDelete(deleteUrl) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini ? ')) {
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

        // Script untuk pop-up notifikasi
        @if (session('success'))
            alert("Success: {{ session('success') }}");
            const successAlert = document.getElementById('success-alert');
            if(successAlert) successAlert.style.display = 'none';
        @elseif (session('error'))
            alert("Error: {{ session('error') }}");
             const errorAlert = document.getElementById('error-alert');
             if(errorAlert) errorAlert.style.display = 'none';
        @endif
    </script>

</x-app-layout>
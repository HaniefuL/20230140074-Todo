<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert Success --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900/30 border-l-4 border-green-500 text-green-400 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-gray-100">

                    {{-- HEADER DAN TOMBOL --}}
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4 border-b border-gray-700 pb-4">
                        <div>
                            <h2 class="text-3xl font-bold text-white tracking-tight">
                                Category List
                            </h2>
                            <p class="text-gray-400 text-sm mt-1">Manage your product categories.</p>
                        </div>

                        {{-- Tombol Add Category menggunakan komponen --}}
                        @can('create-category')
                            <x-add-product :url="route('category.create')" name="Category" />
                        @endcan
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto border border-gray-700 rounded-lg">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900/50 border-b border-gray-700">
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400">#</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400">NAME</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400 text-center">TOTAL PRODUCT</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400 text-center">ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="border-b border-gray-700 hover:bg-gray-900/30 transition">
                                        <td class="p-4 text-gray-300">{{ $loop->iteration }}</td>
                                        <td class="p-4 text-gray-100 font-semibold">{{ $category->name }}</td>
                                        
                                        {{-- BAGIAN TOTAL PRODUCT --}}
                                        <td class="p-4 text-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-900/40 text-indigo-300">
                                                {{-- Menggunakan products_count dari withCount() di Controller --}}
                                                {{ $category->products_count ?? 0 }}
                                            </span>
                                        </td>

                                        <td class="p-4">
                                            <div class="flex items-center justify-center gap-2">
                                                @can('edit-category')
                                                    <x-edit-product :url="route('category.edit', $category)" />
                                                @endcan
                                                
                                                @can('delete-category')
                                                    <x-delete-product :url="route('category.delete', $category)" />
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-4 text-center text-gray-400">
                                            Belum ada kategori. 
                                            @can('create-category')
                                                <a href="{{ route('category.create') }}" class="text-indigo-400 hover:text-indigo-300">Buat kategori baru</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
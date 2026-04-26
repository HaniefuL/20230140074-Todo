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
                                Product List
                            </h2>
                            <p class="text-gray-400 text-sm mt-1">Manage your product inventory.</p>
                        </div>
                        
                        <div class="flex gap-2">
                            @can('export-product')
                                <a href="{{ route('product.export') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg shadow-sm transition flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Export Product
                                </a>
                            @endcan

                            <x-add-product :url="route('product.create')" name="Product" />
                        </div>
                    </div>

                    {{-- TABEL --}}
                    <div class="overflow-x-auto border border-gray-700 rounded-lg">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-900/50 border-b border-gray-700">
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400">#</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400">NAME</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400 text-center">QUANTITY</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400">PRICE</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400">OWNER</th>
                                    <th class="p-4 font-bold uppercase text-xs text-gray-400 text-center">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse ($products as $index => $product)
                                    <tr class="hover:bg-gray-700/30 transition">
                                        <td class="p-4 text-gray-400">{{ $index + 1 }}</td>
                                        <td class="p-4 font-medium text-gray-100">{{ $product->name }}</td>
                                        <td class="p-4 text-center text-gray-300">{{ $product->quantity }}</td>
                                        <td class="p-4 text-indigo-400 font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-400">
                                            {{ $product->user->name }}
                                        </td>
                                        <td class="p-4 text-center">
                                            <div class="flex justify-center gap-3">
                                                <a href="{{ route('product.show', $product->id) }}" class="text-blue-400 hover:text-blue-300 transition" title="View">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                
                                                <a href="{{ route('product.edit', $product->id) }}" class="text-yellow-400 hover:text-yellow-300 transition" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('product.delete', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-gray-400 italic">
                                            Belum ada data produk yang terdaftar.
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
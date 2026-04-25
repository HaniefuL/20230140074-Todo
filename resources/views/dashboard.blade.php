<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-gray-100">
                    <div class="mb-4">
                        <p class="text-lg font-semibold">Selamat datang, {{ Auth::user()->name }}!</p>
                        <p class="text-gray-400 text-sm mt-1">Anda login sebagai: <span class="text-blue-400 font-medium">{{ Auth::user()->role }}</span></p>
                    </div>
                    <div class="text-sm text-gray-300 space-y-2 mt-6 border-t border-gray-700 pt-4">
                        <p class="text-lg font-semibold mb-3">📊 Menu Aplikasi:</p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2">
                                <span class="text-blue-400">→</span>
                                <a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a>
                                <span class="text-gray-500 text-xs">- Halaman utama</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-blue-400">→</span>
                                <a href="{{ route('product.index') }}" class="hover:text-white transition">Product</a>
                                <span class="text-gray-500 text-xs">- Kelola produk dan inventory</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="text-blue-400">→</span>
                                <a href="{{ route('about') }}" class="hover:text-white transition">About</a>
                                <span class="text-gray-500 text-xs">- Informasi aplikasi</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

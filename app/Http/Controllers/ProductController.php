<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Penting untuk authorize

class ProductController extends Controller
{
    use AuthorizesRequests; // Memastikan trait authorize bisa dipake

    public function index()
    {
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    /**
     * Method untuk Export (Sesuai tugas Kelas B)
     */
    public function export()
    {
        // Pastikan login sebagai admin baru bisa tembus sini karena middleware Gate
        return "Halaman Export Produk (Hanya Admin)";
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
        ]);

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('product.view', compact('product'));
    }

    public function edit(Product $product)
    {
        // LANGKAH 4: Cek Policy sebelum masuk halaman edit
        $this->authorize('update', $product);

        $users = User::orderBy('name')->get();
        return view('product.edit', compact('product', 'users'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // LANGKAH 4: Cek Policy sebelum proses update data
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer',
            'price' => 'sometimes|numeric',
            'user_id' => 'sometimes|exists:users,id',
        ]);

        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        // LANGKAH 4: Cek Policy sebelum proses hapus
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests; // Memastikan trait authorize bisa dipake

    public function index()
    {
        $products = Product::all(); // Mengambil semua data
        return view('product.index', compact('products')); // Mengirim variabel $products
    }

    /**
     * Method untuk Export (Sesuai tugas Kelas B)
     */
    public function export()
{
    // Pastikan hanya admin yang bisa akses lewat URL langsung
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $products = \App\Models\Product::with('user')->get();

    $fileName = 'products_report_' . now()->format('Y-m-d') . '.csv';
    $headers = [
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    ];

    $columns = ['ID', 'Product Name', 'Quantity', 'Price', 'Owner'];

    $callback = function() use($products, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($products as $product) {
            fputcsv($file, [
                $product->id,
                $product->name,
                $product->quantity,
                $product->price,
                $product->user->name,
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('product.create', compact('users'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if (auth()->user()->role !== 'admin') {
            $validated['user_id'] = auth()->id();
        }

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

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // LANGKAH 4: Cek Policy sebelum proses update data
        $this->authorize('update', $product);

        $validated = $request->validated();

        if (auth()->user()->role !== 'admin') {
            $validated['user_id'] = $product->user_id;
        }

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
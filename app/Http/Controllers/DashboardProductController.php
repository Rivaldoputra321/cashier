<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('dashboard.dashboard_product.dashboard_product_index', [
            'products' => Product::all(),'categories' => $categories
        ]);

        $products = Product::all(); 
        Log::info('Products fetched:', $products->toArray()); // Log products to storage/logs/laravel.log
        return response()->json($products); 

    }

    public function create()
    {

        $categories = Category::all();
        return view('dashboard.dashboard_product.dashboard_product_add', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validate = $request->validate([
            'name' => 'required|string|unique:products,name',
            'harga' => 'required',
            'stok' => 'required|int',
        ]);

        // Gather all validated data
        $data = $request->all();

        // Create a new Product instance and set the data
        $product = new Product($data);

        // Generate and set the 'kd_product' value
        $product->kd_product = $this->generateKodeBarang();

        // Save the product to the database
        $product->save();

        // Attach categories after saving the product
        $product->categories()->attach($request->categories);

        // Redirect with success message
        return redirect()->route('dashboard_product.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function edit($slug)
    {
        return view('dashboard.dashboard_product.dashboard_product_edit', [
            'product' => Product::where('slug', $slug)->firstOrFail(),'categories' => Category::all()
        ]);
    }

    public function update(Request $request, $slug)
    {

        $product = Product::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'harga' => 'required',
            'stok' => 'required',            
        ]);
    
       

        $product->slug = null;

        $product->update($request->all());

        $product->categories()->sync([$request->categories]);

        return redirect()->route('dashboard_product.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    private function generateKodeBarang()
    {
        $lastProduct = Product::latest()->first();
        $lastNumber = $lastProduct ? intval(substr($lastProduct->kd_product, 3)) : 0;
        $newNumber = $lastNumber + 1;
        return 'PRD' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }
    

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();

        return redirect()->route('dashboard_product.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}

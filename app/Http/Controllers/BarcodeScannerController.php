<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\DetailSale;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;

class BarcodeScannerController extends Controller
{

    public function showByKodeProduct($kd_product)
{
    $product = Product::where('kd_product', $kd_product)->first();

    if ($product) {
        return response()->json($product);
    } else {
        return response()->json(['message' => 'Product not found'], 404);
    }
}

public function addToCart(Request $request, $kd_product)
{
    // Get the current sale (transaction) for the user
    $sale = Sale::where('user_id', auth()->user()->id)
        ->where('status', 0)
        ->first();

    // Find the product by kd_product (barcode)
    $product = Product::where('kd_product', $kd_product)->first();

    if (!$product) {
        return response()->json(['message' => 'Produk tidak ditemukan'], 404);
    }

    // Check if stock is available
    if ($product->stok == 0) {
        return response()->json(['message' => 'Stok produk habis'], 400);
    }

    // Check if the product is already in the cart
    $detailSale = DetailSale::where('sales_id', $sale->id)
        ->where('product_id', $product->id)
        ->first();

    $quantityToAdd = 1; // Adding one item

    // If product is already in the cart, update quantity and subtotal
    if ($detailSale) {
        $detailSale->jumlah_product += $quantityToAdd;
        $detailSale->subtotal += $product->harga * $quantityToAdd;
        $detailSale->save();
    } else {
        // If product is not in the cart, add it
        DetailSale::create([
            'sales_id' => $sale->id,
            'product_id' => $product->id,
            'jumlah_product' => $quantityToAdd,
            'subtotal' => $product->harga * $quantityToAdd,
        ]);
    }

    // Decrease the product stock
    $product->stok -= $quantityToAdd;
    $product->save();

    // Update the total price for the sale
    $sale->total_harga += $product->harga * $quantityToAdd;
    $sale->save();

    return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang', 'sale' => $sale], 200);
}


}

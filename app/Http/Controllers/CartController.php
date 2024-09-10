<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\DetailSale;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Add a product to the cart by barcode or product ID.
     */
    public function addToCart(Request $request, $id)
    {
        // Get the active sale (cart) for the logged-in user
        $sale = Sale::where('user_id', auth()->user()->id)
            ->where('status', 0) // 0 indicates the cart is still open
            ->first();

        // If no sale (cart) exists, create a new one
        if (!$sale) {
            $sale = Sale::create([
                'user_id' => auth()->user()->id,
                'total_harga' => 0,
                'status' => 0
            ]);
        }

        // Find the product by ID or barcode
        $product = Product::where('id', $id)->orWhere('kd_product', $id)->first();

        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        if ($product->stok == 0) {
            return response()->json(['error' => 'Stok produk habis'], 400);
        }

        // Check if the product is already in the cart
        $detailSale = DetailSale::where('sales_id', $sale->id)
            ->where('product_id', $product->id)
            ->first();

        $quantityToAdd = 1; // Number of items to add

        if ($detailSale) {
            // If product is already in the cart, update the quantity and subtotal
            $newQuantity = $detailSale->jumlah_product + $quantityToAdd;
            $detailSale->jumlah_product = $newQuantity;
            $detailSale->subtotal += $product->harga * $quantityToAdd;
            $detailSale->save();
        } else {
            // If product is not in the cart, create a new entry in DetailSale
            $detailSale = DetailSale::create([
                'sales_id' => $sale->id,
                'product_id' => $product->id,
                'jumlah_product' => $quantityToAdd,
                'subtotal' => $product->harga * $quantityToAdd,
            ]);
        }

        // Update product stock
        $product->stok -= $quantityToAdd;
        $product->save();

        // Update the total price of the sale (cart)
        $sale->total_harga += $product->harga * $quantityToAdd;
        $sale->save();

        return response()->json(['success' => 'Produk berhasil ditambahkan ke keranjang'], 200);
    }
}

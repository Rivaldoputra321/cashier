<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\DetailSale;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();
        $sale = Sale::where('user_id', auth()->user()->id)
                    ->where('status', 0)
                    ->first();
    
        if (!$sale) {
            $sale = Sale::create([
                'user_id' => auth()->user()->id,
                'total_harga' => 0,
                'status' => 0
            ]);
        }
    
        $sale->load('detailSales');
    
        return view('kasir.transaksi', compact('products', 'sale'))->with('success', 'transaksi baru sudah dibuat');
    }

    public function addToCart(Request $request, $id)
    {
        $sale = Sale::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->first();

        if (!$sale) {
            $sale = Sale::create([
                'user_id' => auth()->user()->id,
                'total_harga' => 0,
                'status' => 0
            ]);
        }

        $product = Product::where('id', $id)->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        if ($product->stok == 0) {
            return redirect()->back()->with('error', 'Stok produk habis');
        }

        $detailSale = DetailSale::where('sales_id', $sale->id)
            ->where('product_id', $id)
            ->first();

        $quantityToAdd = 1; // Adding one item

        if ($detailSale) {
            $newQuantity = $detailSale->jumlah_product + $quantityToAdd;

            $detailSale->jumlah_product = $newQuantity;
            $detailSale->subtotal += $product->harga * $quantityToAdd;
            $detailSale->save();
        } else {
            if ($quantityToAdd > $product->stok) {
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
            }

            $detailSale = DetailSale::create([
                'sales_id' => $sale->id,
                'product_id' => $id,
                'jumlah_product' => $quantityToAdd,
                'subtotal' => $product->harga * $quantityToAdd,
            ]);
        }

        $product->stok -= $quantityToAdd;
        $product->save();

        $sale->total_harga += $product->harga * $quantityToAdd;
        $sale->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    public function checkout(Request $request)
{
    $sale = Sale::where('user_id', auth()->user()->id)
                ->where('status', 0)
                ->first();

    if (!$sale) {
        return redirect()->back()->with('error', 'Tidak ada transaksi aktif untuk checkout');
    }

    if ($sale->detailSales->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang belanja kosong');
    }

    // Retrieve the received amount from the form
    $receivedAmount = $request->input('received_amount');

    if (!$receivedAmount || $receivedAmount < $sale->total_harga) {
        return redirect()->back()->with('error', 'Jumlah uang yang diterima tidak cukup');
    }else{
        $changeAmount = $receivedAmount - $sale->total_harga;

    // Update sale record
    $sale->diterima = $receivedAmount;
    $sale->kembali = $changeAmount;
    $sale->total_item = $sale->detailSales->sum('jumlah_product');
    $sale->status = 1;
    $sale->tgl_penjualan = now(); // Save the current timestamp
    $sale->save();

    return redirect()->back()->with('success', 'Transaksi berhasil di-checkout');
        
    }

    // Calculate the change
}


    public function minus($id)
    {
        $sale = Sale::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->first();

        if (!$sale) {
            return redirect()->back()->with('error', 'Tidak ada penjualan aktif yang ditemukan.');
        }

        $detailSale = DetailSale::where('sales_id', $sale->id)
            ->where('product_id', $id)
            ->first();

        if (!$detailSale) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang');
        }

        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }
        $detailSale->subtotal -= $product->harga * 1;
        $detailSale->jumlah_product -= 1;
        $product->stok += 1;

        $sale->total_harga -= $product->harga;

        if ($detailSale->jumlah_product <= 0) {
            $detailSale->delete();
        } else {
            $detailSale->save();
        }

        $sale->save();
        $product->save();

        return redirect()->back()->with('success', 'Jumlah produk dalam keranjang berhasil dikurangi');
    }

    public function plus($id)
    {
        $sale = Sale::where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->first();

        if (!$sale) {
            return redirect()->back()->with('error', 'Tidak ada penjualan aktif yang ditemukan.');
        }

        $detailSale = DetailSale::where('sales_id', $sale->id)
            ->where('product_id', $id)
            ->first();

        if (!$detailSale) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang');
        }

        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        if ($product->stok == 0) {
            return redirect()->back()->with('error', 'Stok produk habis');
        }

        $detailSale->jumlah_product += 1;
        $product->stok -= 1;
        $detailSale->subtotal += $product->harga * 1;
        $sale->total_harga += $product->harga;

        $detailSale->save();
        $sale->save();
        $product->save();

        return redirect()->back()->with('success', 'Jumlah produk dalam keranjang berhasil ditambah');
    }

    public function delete($id)
{
    $sale = Sale::where('user_id', auth()->user()->id)
        ->where('status', 0)
        ->first();

    if (!$sale) {
        return redirect()->back()->with('error', 'Tidak ada penjualan aktif yang ditemukan.');
    }

    $detailSale = DetailSale::where('sales_id', $sale->id)
        ->where('product_id', $id)
        ->first();

    if (!$detailSale) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan di keranjang');
    }

    $product = Product::find($id);

    if (!$product) {
        return redirect()->back()->with('error', 'Produk tidak ditemukan');
    }

    // Update product stock before deletion
    $product->stok += $detailSale->jumlah_product;
    $product->save();

    // Update sale total price
    $sale->total_harga -= $detailSale->subtotal;
    $sale->save();

    // Delete the detail sale record
    $detailSale->delete();

    return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang');
}


    
}

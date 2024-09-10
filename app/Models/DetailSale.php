<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'jumlah_product', 'subtotal', 'sales_id', 'product_id', 
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function sales()
    {
        return $this->belongsTo(Sale::class, 'sales_id');
    }
}

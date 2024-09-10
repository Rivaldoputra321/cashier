<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_harga', 'status','customers_id', 'total_item', 'tgl_penjualan', 'diterima', 'kembali'
    ];

    protected $casts = [
        'tgl_penjualan' => 'datetime',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}

    public function detailSales()
    {
        return $this->hasMany(DetailSale::class, 'sales_id');
    }
}

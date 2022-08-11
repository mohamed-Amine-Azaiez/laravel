<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'qte', 'price'
    ];
    public function User()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function Product()
    {
        return $this->belongsToMany(Product::class, 'OrderProduct');
    }
}

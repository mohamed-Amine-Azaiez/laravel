<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'ref', 'sub_category_id', 'price', 'quantity', 'provider_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'provide_id');
    }
    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function Commande()
    {
        return $this->belongsToMany(Commande::class, 'CommandeProduct');
    }
    public function order()
    {
        return $this->belongsToMany(order::class, 'OrderProduct');
    }
    public function ProductImage()
    {
        return $this->hasMany(ProductImage::class);
    }
}

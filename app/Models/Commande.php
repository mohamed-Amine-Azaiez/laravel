<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 'montant', 'lieuLivraison', 'prixTotal', 'typeLivraison', 'modePayment', 'deliveryPrice', 'customer_id'
    ];
    public function Product()
    {
        return $this->belongsToMany(Product::class, 'CommandeProduct');
    }
    public function Facture()
    {
        return $this->hasOne(Facture::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}

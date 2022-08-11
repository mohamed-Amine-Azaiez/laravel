<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = [
        'refFacture', 'date', 'remise', 'total', 'description', 'commande_id'
    ];

    public function Commande()
    {
        return $this->belongsTo(Commande::class, 'commande_id');
    }
}

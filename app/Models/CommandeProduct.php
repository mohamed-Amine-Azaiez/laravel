<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandeProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_product', 'id_commande', 'qte'
    ];
}

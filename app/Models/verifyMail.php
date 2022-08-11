<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verifyMail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'token', 'expire_at'
    ];


    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

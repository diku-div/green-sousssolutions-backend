<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'email', 'nom', 'prenom', 'ville', 'adresse',
        'numero_telephone', 'numero_whatsapp', 'quantite', 'price', 'status'
    ];
}

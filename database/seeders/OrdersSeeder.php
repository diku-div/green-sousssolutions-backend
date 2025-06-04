<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run()
    {
        Order::create([
            'email' => 'john@example.com',
            'nom' => 'Doe',
            'prenom' => 'John',
            'ville' => 'Casablanca',
            'adresse' => '123 Street Name',
            'numero_telephone' => '+212612345678',
            'numero_whatsapp' => '+212612345678',
            'quantite' => 2,
            'price' => 199.99,
        ]);
    }
}

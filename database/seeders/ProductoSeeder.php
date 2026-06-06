<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Producto::create([
            'nombre'=>'Laptop',
            'descripcion'=>'Laptop gamer',
            'precio'=>15000,
            'stock'=>5
        ]);

        Producto::create([
            'nombre'=>'Mouse',
            'descripcion'=>'Mouse RGB',
            'precio'=>500,
            'stock'=>10
        ]);
    }
}

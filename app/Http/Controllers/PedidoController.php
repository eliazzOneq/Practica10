<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pedido;

class PedidoController extends Controller
{
    public function __invoke(Request $request)
    {
        $items = $request->items;
        $total = collect($items)->sum(function ($item) {

            return
                $item['precio']
                *
                $item['cantidad'];

        });

        $pedido = Pedido::create([

            'items' => json_encode($items),

            'total' => $total

        ]);

        return response()->json([

            'message' => 'Pedido guardado',

            'pedido' => $pedido

        ], 201);
    }
}
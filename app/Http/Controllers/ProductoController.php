<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Resources\ProductoResource;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productos = Producto::with('categoria')
            ->buscar($request->busqueda)
            ->deCategoria($request->categoria_id)
            ->rangoPrecio(
                $request->precio_min,
                $request->precio_max
            )
            ->orderBy(
                $request->get('orden', 'nombre'),
                $request->get('dir', 'asc')
            )
            ->paginate(
                $request->get('por_pagina', 15)
            );
        return ProductoResource::collection($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {   
        //$this->authorize('create', Producto::class);
        $data = $request->validated();
        unset($data['imagen']);
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request
                ->file('imagen')
                ->store('productos', 'public');
        }

        $producto = Producto::create($data);
        return response()->json(
            $producto,
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $producto->imagen_url = $producto->imagen
            ? asset('storage/' . $producto->imagen)
            : null;

        return response()->json(
            $producto,
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateProductoRequest $request,
        Producto $producto
    )
    {
        //$this->authorize('update', $producto);

        $data = $request->except('imagen');
        
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request
                ->file('imagen')
                ->store('productos', 'public');
        }

        $producto->update($data);

        $producto->imagen_url = $producto->imagen
            ? asset('storage/' . $producto->imagen)
            : null;

        return response()->json(
            $producto,
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //$this->authorize('delete', $producto);

        $producto->delete();

        return response()->json(
            null,
            204
        );
    }
}

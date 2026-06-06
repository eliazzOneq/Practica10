<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Producto;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductoTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_listar_productos()
    {
        Producto::factory()->count(5)->create();

        $response = $this->getJson('/api/productos');

        $response->assertStatus(200);
    }

    public function test_puede_crear_producto()
    {
        $response = $this->postJson('/api/productos', [
            'nombre' => 'Laptop Dell',
            'descripcion' => 'Laptop para pruebas',
            'precio' => 15000,
            'stock' => 10
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('productos', [
            'nombre' => 'Laptop Dell'
        ]);
    }

    public function test_puede_mostrar_producto()
    {
        $producto = Producto::factory()->create();

        $response = $this->getJson(
            "/api/productos/{$producto->id}"
        );

        $response->assertStatus(200);
    }

    public function test_puede_eliminar_producto()
    {
        $producto = Producto::factory()->create();

        $response = $this->deleteJson(
            "/api/productos/{$producto->id}"
        );

        $response->assertStatus(204);

        $this->assertDatabaseMissing('productos', [
            'id' => $producto->id
        ]);
    }

    public function test_no_permite_crear_producto_sin_nombre()
    {
        $response = $this->postJson('/api/productos', [
            'precio' => 100,
            'stock' => 5
        ]);

        $response->assertStatus(422);
    }

    public function test_cliente_no_puede_eliminar(): void
    {
        $cliente = User::factory()->create([
            'rol' => 'cliente'
        ]);

        $producto = Producto::factory()->create();
        $this->actingAs($cliente, 'sanctum')
            ->deleteJson("/api/productos/{$producto->id}")
            ->assertForbidden();
    }
}
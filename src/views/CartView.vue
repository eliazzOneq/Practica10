<template>
  <div>
    <h1>Carrito</h1>
    <div v-for="item in carrito.items" :key="item.id">

      <h3>{{ item.nombre }}</h3>

      <p>Precio: ${{ item.precio }}</p>

      <button @click="carrito.cambiarCantidad(
            item.id,
            item.cantidad - 1
          ) ">-</button>

      {{ item.cantidad }}

      <button @click="carrito.cambiarCantidad(
            item.id,
            item.cantidad + 1
        ) ">+</button>

      <button @click="carrito.quitar(item.id)">X</button>

      <p>Subtotal: ${{ item.precio * item.cantidad }}</p>

      <hr>
    </div>

    <h2>
      Total:
      ${{ carrito.totalPrecio }}
    </h2>

    <button @click="vaciar">Vaciar carrito</button>
    <button @click="finalizarCompra">Finalizar compra</button>
  </div>
</template>

<script setup>
import { useCarritoStore } from '@/stores/carrito'
import axios from 'axios'

const carrito = useCarritoStore()

const vaciar = () => {
  if (
    confirm('¿Vaciar carrito?')
  ) {
    carrito.vaciar()
  }
}

const finalizarCompra = async () => {
  try {
    await axios.post(
      'http://127.0.0.1:8000/api/pedidos',
      {
        items: carrito.items
      }
    )

    alert('Pedido realizado')
    carrito.vaciar()
  } catch (error) {
    console.log(error)
    alert('Error al finalizar')
  }
}
</script>
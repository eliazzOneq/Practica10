<template>
  <div>
    <h1>Bienvenido</h1>

    <h2>Últimos productos</h2>

    <div v-for="producto in productos" :key="producto.id">
      <h3>{{ producto.nombre }}</h3>
      <p>${{ producto.precio }}</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { getProductos } from '@/services/productoService'

const productos = ref([])

onMounted(async () => {
  const response = await getProductos()

  productos.value = response.data.slice(0, 3)
})
</script>
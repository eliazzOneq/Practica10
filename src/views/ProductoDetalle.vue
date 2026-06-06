<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const volver = () => {
  router.back()
}

const props = defineProps({
  id: String
})

const producto = ref({
  nombre: '',
  descripcion: '',
  precio: '',
  stock: ''
})

const cargarProducto = async () => {

  try {
    const res = await axios.get(
      `http://127.0.0.1:8000/api/productos/${props.id}`
    )
    producto.value.nombre = res.data.nombre
    producto.value.descripcion = res.data.descripcion
    producto.value.precio = res.data.precio
    producto.value.stock = res.data.stock
    console.log(producto.value)
  } catch(error) {
    console.error(error)
  }
}

onMounted(() => {
  cargarProducto()
})
</script>

<template>
  <div>
    <h1>Detalle Producto</h1>

    <h2>{{ producto.nombre }}</h2>

    <p>{{ producto.descripcion }}</p>

    <p>${{ producto.precio }}</p>

    <p>Stock: {{ producto.stock }}</p>
  </div>

  <button @click="volver">Volver al catálogo</button>
</template>
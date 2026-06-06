<template>
  <div>
    <h1>Catálogo</h1>

    <FiltrosPanel
      :filtros="filtros"
      :categorias="categorias"/>

    <div v-for="producto in productos"
      :key="producto.id">

      <img v-if="producto.imagen_url"
        :src="producto.imagen_url"
        :alt="producto.nombre"
        width="200"
      />

      <h3>{{ producto.nombre }}</h3>
      <p>${{ producto.precio }}</p>

      <router-link :to="`/catalogo/${producto.id}`">Ver detalle</router-link>
      <br><br>
      <button @click="carrito.agregar(producto)">

        <template v-if="carrito.cantidadDeProducto(producto.id) > 0">
          En carrito
          (
          {{
            carrito.cantidadDeProducto(producto.id)
          }}
          )
        </template>
        <template v-else>Agregar al carrito</template>
      </button>
      <hr>
    </div>

    <PaginacionNav
      :meta="meta"
      @cambio-pagina="filtros.pagina = $event"/>

    
    <span>Página {{ meta.current_page }} de {{ meta.last_page }}</span>
    
  </div>
</template>

<script setup>
import axios from 'axios'
import { ref, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { useFiltros } from '@/composables/useFiltros'
import FiltrosPanel from '@/components/FiltrosPanel.vue'
import PaginacionNav from '@/components/PaginacionNav.vue'
import { useCarritoStore } from '@/stores/carrito'

const carrito = useCarritoStore()
const productos = ref([])
const categorias = ref([])
const route = useRoute()
const { filtros } = useFiltros()
const busquedaDebounce = ref()
const meta = ref({})

const cargarCategorias = async () => {
  const response = await axios.get(
    'http://127.0.0.1:8000/api/categorias'
  )

  categorias.value = response.data.data
}

const cargarProductos = async () => {
  const response = await axios.get(
    'http://127.0.0.1:8000/api/productos',
    {
      params: {
        busqueda: filtros.busqueda,
        categoria_id: filtros.categoria_id,
        precio_min: filtros.precio_min,
        precio_max: filtros.precio_max,
        page: filtros.pagina
      }
    }
  )
  productos.value = response.data.data
  meta.value = response.data.meta
}

onMounted(async () => {
  await cargarProductos()
  await cargarCategorias()
})

watch(
  () => filtros.busqueda,
  () => {
    clearTimeout(busquedaDebounce.value)
    busquedaDebounce.value = setTimeout(() => {
      filtros.pagina = 1
    }, 300)

  }
)

watch(
  () => route.query,
  cargarProductos,
  { immediate: true }
)
</script>
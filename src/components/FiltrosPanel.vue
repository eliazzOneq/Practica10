<template>
<div>
    <input v-model="busquedaLocal" placeholder="Buscar producto">

    <select v-model="filtros.categoria_id">
        <option value=""> Todas las categorías</option>
        <option
            v-for="categoria in categorias"
            :key="categoria.id"
            :value="categoria.id"
        >
            {{ categoria.nombre }}
        </option>
    </select>

    <input type="number" v-model="filtros.precio_min" placeholder="Precio mínimo">
    <input type="number" v-model="filtros.precio_max" placeholder="Precio máximo">

    <button @click="limpiar">Limpiar filtros</button>
</div>
</template>

<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
    filtros: Object,
    categorias: Array
})
const busquedaLocal = ref(props.filtros.busqueda)

function limpiar() {
    props.filtros.busqueda = ''
    props.filtros.categoria_id = ''
    props.filtros.precio_min = ''
    props.filtros.precio_max = ''
    props.filtros.pagina = 1

}

let timeout = null
watch(busquedaLocal, (valor) => {
    clearTimeout(timeout)
    timeout = setTimeout(() => {
        props.filtros.busqueda = valor
    }, 300)
})
</script>
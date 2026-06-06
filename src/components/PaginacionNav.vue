<template>
<div v-if="meta.last_page">

    <button
        @click="cambiarPagina(1)"
        :disabled="meta.current_page === 1"
    >Primera</button>

    <button
        @click="cambiarPagina(meta.current_page - 1)"
        :disabled="meta.current_page === 1"
    >Anterior</button>

    Página {{ meta.current_page }}
    de {{ meta.last_page }}

    <button
        @click="cambiarPagina(meta.current_page + 1)"
        :disabled="meta.current_page === meta.last_page"
    >Siguiente</button>

    <button
        @click="cambiarPagina(meta.last_page)"
        :disabled="meta.current_page === meta.last_page"
    >Última</button>

</div>
</template>

<script setup>

const props = defineProps({
    meta: Object
})

const emit = defineEmits([
    'cambio-pagina'
])

function cambiarPagina(pagina) {
    emit('cambio-pagina', pagina)
}

</script>
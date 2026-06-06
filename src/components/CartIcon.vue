<template>
  <router-link to="/carrito">
    🛒
    <span
      v-if="carrito.totalItems > 0"
    >
      ({{ carrito.totalItems }})
    </span>
  </router-link>
</template>

<script setup>
import { useCarritoStore } from '@/stores/carrito'

const carrito = useCarritoStore()
</script>
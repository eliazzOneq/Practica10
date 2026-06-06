<style>
body{
  font-family: Arial, sans-serif;
}
</style>

<template>
  <div>
    <nav>
      <router-link to="/">Inicio</router-link> |
      <router-link to="/catalogo">Catálogo</router-link> |
      <router-link to="/login">Admin</router-link> |
      <CartIcon />
    </nav>

    <router-view />
  </div>
</template>

<script setup>
  import CartIcon from '@/components/CartIcon.vue'
</script>
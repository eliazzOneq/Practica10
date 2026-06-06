<template>
  <div>
    <h1>Panel Admin</h1>
    <nav>
      <router-link to="/admin">
        Dashboard
      </router-link>
      |
      <router-link to="/admin/productos">
        Productos
      </router-link>
    </nav>
    <router-view />
  </div>
</template>
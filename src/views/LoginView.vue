<template>
  <div>
    <h1>Login</h1>

    <form @submit.prevent="login">

      <input
        v-model="email"
        type="email"
        placeholder="Correo"
      />

      <br><br>

      <input
        v-model="password"
        type="password"
        placeholder="Contraseña"
      />

      <br><br>

      <button>
        Ingresar
      </button>

    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter, useRoute } from 'vue-router'

const router = useRouter()
const route = useRoute()

const email = ref('')
const password = ref('')

const login = async () => {
  try {
    const response = await axios.post(
      'http://127.0.0.1:8000/api/login',
      {
        email: email.value,
        password: password.value
      }
    )

    localStorage.setItem(
      'token',
      response.data.token
    )

    router.push(
      route.query.redirect || '/admin'
    )

  } catch (error) {
    alert(
      error.response?.data?.message ||
      'Credenciales incorrectas'
    )
  }
}
</script>
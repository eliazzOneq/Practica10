import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    permisos: {
      crear: false,
      editar: false,
      eliminar: false
    }
  }),

  actions: {
    setUser(data) {
      this.user = data

      if (data.permisos) {
        this.permisos = data.permisos
      }
    }
  }
})
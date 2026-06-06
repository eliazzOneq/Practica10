import { defineStore } from 'pinia'

export const useCarritoStore = defineStore('carrito', {

  state: () => ({
    items: JSON.parse(
      localStorage.getItem('carrito') || '[]'
    )
  }),

  getters: {
    totalItems: (state) =>
      state.items.reduce(
        (suma, item) => suma + item.cantidad,
        0
      ),

    totalPrecio: (state) =>
      state.items.reduce(
        (suma, item) =>
          suma + item.precio * item.cantidad,
        0
      ),

    cantidadDeProducto: (state) => (id) =>
      state.items.find(i => i.id === id)?.cantidad || 0
  },

  actions: {
    agregar(producto) {
      const item = this.items.find(
        i => i.id === producto.id
      )
      if (item) {
        item.cantidad++
      } else {
        this.items.push({
          ...producto,
          cantidad: 1
        })
      }
      this.guardar()
    },

    quitar(id) {
      this.items = this.items.filter(
        i => i.id !== id
      )
      this.guardar()
    },

    cambiarCantidad(id, cantidad) {
      const item = this.items.find(
        i => i.id === id
      )
      if (!item) return
      item.cantidad = cantidad
      if (item.cantidad <= 0) {
        this.quitar(id)
      }
      this.guardar()
    },

    vaciar() {
      this.items = []
      this.guardar()
    },

    guardar() {
      localStorage.setItem(
        'carrito',
        JSON.stringify(this.items)
      )
    }
  }
})
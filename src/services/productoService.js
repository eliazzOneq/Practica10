import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api'
})

api.interceptors.request.use(config => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

export const getProductos = (params = {}) =>
  api.get('/productos', { params })

export const getProducto = (id) =>
  api.get(`/productos/${id}`)

export const createProducto = (data) =>
  api.post('/productos', data)

export const updateProducto = (id, data) =>
  api.post(`/productos/${id}`, data)

export const deleteProducto = (id) =>
  api.delete(`/productos/${id}`)
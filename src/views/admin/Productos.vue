<script setup>
  import { useAuthStore } from '@/stores/auth'
  import axios from 'axios'
  import { ref, onMounted } from 'vue'
  import { useForm } from 'vee-validate'
  import { productoSchema } from '@/schemas/productoSchema'
  import InputField from '@/components/InputField.vue'

  import {
    getProductos,
    createProducto,
    updateProducto,
    deleteProducto
  } from '@/services/productoService'

  const auth = useAuthStore()
  const productos = ref([])
  const categorias = ref([])
  const editando = ref(false)

  const imagen = ref(null)
  const preview = ref(null)
  const erroresServidor = ref({})

  const {
    handleSubmit,
    errors
  } = useForm({
    validationSchema: productoSchema,
    validateOnMount: false
  })

  const cargarUsuario = async () => {
    try {
      const token = localStorage.getItem('token')
      console.log(localStorage.getItem('token'))
      const response = await axios.get(
        'http://127.0.0.1:8000/api/me',
        {
          headers: {
            Authorization: `Bearer ${token}`
          }
        }
      )
      console.log(response.data)
      auth.setUser(response.data)

    } catch (error) {
      console.error('Error /api/me:', error)
    }
  }

  const form = ref({
    id:null,
    nombre:'',
    descripcion:'',
    precio:'',
    stock:'',
    categoria_id:''
  })

  const cargarProductos = async () => {
    try {
      const response = await getProductos({
        por_pagina: 100
      })
      productos.value = response.data.data

    } catch (error) {
      console.error(error)
    }
  }

  const cargarCategorias = async () => {
    const response = await axios.get(
      'http://127.0.0.1:8000/api/categorias'
    )
    categorias.value = response.data.data
  }

  const onImageChange = (e) => {
    const file = e.target.files[0]
    if (!file) return
    imagen.value = file
    preview.value =
      URL.createObjectURL(file)
  }

  const guardarProducto = async () => {
    console.log('ENTRO A GUARDAR')
    try{
      const fd = new FormData()
      fd.append('nombre', form.value.nombre)
      fd.append('descripcion', form.value.descripcion)
      fd.append('precio', form.value.precio)
      fd.append('stock', form.value.stock)
      fd.append('categoria_id', form.value.categoria_id)

      if(imagen.value){
        fd.append('imagen', imagen.value)
      }

      if(editando.value){
        fd.append('_method', 'PUT')
        await updateProducto(
          form.value.id,
          fd
        )

      } else {
        await createProducto(fd)
      }

      erroresServidor.value = {}
      limpiarFormulario()
      await cargarProductos()
      alert('Producto guardado correctamente')

    } catch(error){
      console.error(error)

      console.log('STATUS:', error.response?.status)
      console.log('DATA:', error.response?.data)

      if(error.response?.status === 422){
        erroresServidor.value =
          error.response.data.errors
        return
      }
    }
  }

  const editarProducto=(producto)=>{
    editando.value=true
    form.value={...producto}
    preview.value = producto.imagen_url
  }

  const limpiarFormulario=()=>{
    editando.value=false
    form.value={
      id:null,
      nombre:'',
      descripcion:'',
      precio:'',
      stock:'',
      categoria_id:''
    }

    imagen.value = null
    preview.value = null
  }

  const eliminarProducto = async(id)=>{
    if(!confirm('¿Eliminar producto?')){
      return
    }

    try{
      await deleteProducto(id)
      await cargarProductos()
      alert('Producto eliminado')
    }catch(error){
      if(error.response?.status === 403){
        alert('No tienes permisos para eliminar productos')
        return
      }
      console.error(error)
    }
  }

  onMounted(async () => {
    await cargarUsuario()
    await cargarProductos()
    await cargarCategorias()
  })
</script>

<template>
  <h1>CRUD Productos</h1>
  <p>Rol actual:<strong>{{ auth.user?.rol }}</strong></p>
  <h2>
    {{ editando
    ? 'Editar Producto'
    : 'Nuevo Producto'
    }}
  </h2>

  <div>
    <InputField label="Nombre del producto" v-model="form.nombre" placeholder="Nombre"
      :error="erroresServidor.nombre?.[0]"
    />
  </div>
  <div>
    <InputField label="Descripción" v-model="form.descripcion" placeholder="Descripción"
      :error="erroresServidor.descripcion?.[0]"
    />
  </div>
  <div>
    <InputField label="Precio" v-model="form.precio" type="number" placeholder="Precio"
      :error="erroresServidor.precio?.[0]"
    />
  </div>
  <div>
    <InputField label="Stock" v-model="form.stock" type="number" placeholder="Stock"
      :error="erroresServidor.stock?.[0]"
    />
  </div>

  <select v-model="form.categoria_id">
    <option value="">Selecciona una categoría</option>
    <option v-for="categoria in categorias"
      :key="categoria.id"
      :value="categoria.id">{{ categoria.nombre }}</option>
  </select>

  <div v-if="preview">
    <img :src="preview" width="200"/>
  </div>

  <input type="file" accept="image/*" @change="onImageChange"/>

  <button v-if="auth.permisos.crear" @click="guardarProducto">
    {{ editando
    ? 'Actualizar'
    : 'Guardar'
    }}
  </button>

  <button v-if="editando" @click="limpiarFormulario">Cancelar</button>
  <hr>
  <ul>
    <li v-for="producto in productos" :key="producto.id">
      {{ producto.nombre }} - ${{ producto.precio }} - Stock: {{ producto.stock }}

      <img v-if="producto.imagen_url" :src="producto.imagen_url" width="100"/>

      <button v-can="'editar'" @click="editarProducto(producto)">Editar</button>
      <button v-can="'eliminar'" @click="eliminarProducto(producto.id)">Eliminar</button>
    </li>
  </ul>
</template>
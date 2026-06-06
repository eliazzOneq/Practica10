import { useAuthStore } from '@/stores/auth'

export const vCan = {
  mounted(el, binding) {
    const auth = useAuthStore()
    const permiso = binding.value

    if (!auth.permisos[permiso]) {
      el.style.display = 'none'
    }
  }
}
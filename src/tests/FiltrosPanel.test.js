import { mount } from '@vue/test-utils'
import { describe, it, expect } from 'vitest'
import FiltrosPanel from '@/components/FiltrosPanel.vue'

describe('FiltrosPanel', () => {

    it('renderiza el input de búsqueda', () => {

        const wrapper = mount(FiltrosPanel, {
            props: {
                filtros: {
                    busqueda: '',
                    categoria_id: '',
                    precio_min: '',
                    precio_max: '',
                    pagina: 1
                },
                categorias: []
            }
        })

        expect(
            wrapper.find('input').exists()
        ).toBe(true)

    })

    it('limpia filtros correctamente', async () => {

        const filtros = {
            busqueda: 'Laptop',
            categoria_id: 1,
            precio_min: 100,
            precio_max: 1000,
            pagina: 2
        }

        const wrapper = mount(FiltrosPanel, {
            props: {
                filtros,
                categorias: []
            }
        })

        await wrapper.find('button').trigger('click')

        expect(filtros.busqueda).toBe('')
        expect(filtros.categoria_id).toBe('')
        expect(filtros.precio_min).toBe('')
        expect(filtros.precio_max).toBe('')
        expect(filtros.pagina).toBe(1)
    })
})
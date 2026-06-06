import { mount } from '@vue/test-utils'
import { describe, it, expect } from 'vitest'
import PaginacionNav from '@/components/PaginacionNav.vue'

describe('PaginacionNav', () => {

    it('muestra la página actual', () => {

        const wrapper = mount(PaginacionNav, {
            props: {
                meta: {
                    current_page: 1,
                    last_page: 5
                }
            }
        })

        expect(
            wrapper.text()
        ).toContain('Página 1')
    })

    it('emite evento cambio-pagina', async () => {

        const wrapper = mount(PaginacionNav, {
            props: {
                meta: {
                    current_page: 1,
                    last_page: 5
                }
            }
        })

        await wrapper
            .findAll('button')[2]
            .trigger('click')

        expect(
            wrapper.emitted('cambio-pagina')
        ).toBeTruthy()

    })
})
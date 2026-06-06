import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { vCan } from './directives/can'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.directive('can', vCan)

app.mount('#app')
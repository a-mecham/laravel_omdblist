import AppLayout from "./Layouts/AppLayout";
import Welcome from "./Jetstream/Welcome";
require('./bootstrap');
window.Vue = require('vue').default;

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import App from "./App.vue"; import router from './router.js';
import { InertiaProgress } from '@inertiajs/progress';

import favorites from "./Pages/favorites";
import search from "./Pages/search";


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });

const app = createApp(App)
app.use(router);
app.mount('#app');

/*
const app = new Vue({
    el: '#app',
    components: {
        AppLayout,
        Welcome,
    }
});
*/

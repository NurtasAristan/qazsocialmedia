import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createI18n } from 'vue-i18n' 
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import en from './lang/en.json'
import ru from './lang/ru.json'
import kk from './lang/kk.json'

const i18n = createI18n({
    locale: localStorage.getItem('lang') || 'en', // default
    messages: { en, ru, kk }
})

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n) 
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

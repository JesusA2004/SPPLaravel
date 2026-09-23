import { createInertiaApp } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';
import { reveal } from '@/lib/reveal';

void createInertiaApp({
    title: (title) => title,
    layout: () => SiteLayout,
    withApp: (app) => {
        app.directive('reveal', reveal);
    },
    progress: {
        color: '#ffcc00',
    },
});

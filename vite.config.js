import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/calendar.js',
                'resources/js/usuarios.js',
                'resources/js/eventos.js',
            ],
            refresh: true,
        }),
    ],
});

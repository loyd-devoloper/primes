import { defineConfig } from 'vite';
import laravel , { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/scss/christmas.scss'],
            // refresh: true,
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
     server: {
        host: '20.20.23.100',
        port: 5173,
        cors: {
            origin: ['http://20.20.23.100:8000'], // Allow your Laravel backend
            credentials: true,
        },
        headers: {
            'Access-Control-Allow-Origin': 'http://20.20.23.100:8000',
            'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
            'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization',
        },
    },
});

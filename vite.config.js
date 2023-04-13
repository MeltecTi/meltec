import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: [
                'resources/sass/*',
                'resources/css/*',
                'resources/css/**/*',
                'resources/js/*',
                'resources/js/**/*',
                'resources/lib/**/*',
                'resources/vendors/**/*',
            ],
            refresh: true,
        }),
    ],
});

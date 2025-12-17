import { wayfinder } from '@laravel/vite-plugin-wayfinder';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.tsx'],
            ssr: 'resources/js/ssr.tsx',
            refresh: true,
            detectTls: 'admin.nordicdigitalthailand.com',
        }),
        react(),
        tailwindcss(),
        wayfinder({
            formVariants: true,
        }),
    ],
    server: {
        host: '0.0.0.0',
        port: 4000,
        strictPort: true,
        hmr: {
            host: 'admin.nordicdigitalthailand.com',
            protocol: 'https',
        },
    },
    esbuild: {
        jsx: 'automatic',
    },
});

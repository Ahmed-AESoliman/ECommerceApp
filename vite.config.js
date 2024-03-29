import path from 'path'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
    alias: {
      '@': `${path.resolve(__dirname, 'resources/js/src/')}`,
      '@axios': `${path.resolve(__dirname, 'resources/js/src/libs/axios')}`,
      '@cookies': `${path.resolve(__dirname, 'resources/js/src/libs/cookies')}`
    }
  }
});

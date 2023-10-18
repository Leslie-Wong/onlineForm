import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/scripts/main.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    server: {
        https: {
            key: '/root/.acme.sh/forms.colors.com.hk_ecc/forms.colors.com.hk.key',
            cert: '/root/.acme.sh/forms.colors.com.hk_ecc/fullchain.cer',
        },
        host: '0.0.0.0',
        hmr: { host: '154.26.137.200' }
    }
});

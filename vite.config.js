import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // frontend
                "resources/assets/css/app-frontend.scss",
                "resources/assets/js/app-frontend.js",
                // backend
                "resources/assets/css/app-backend.scss",
                "resources/assets/js/app-backend.js",
            ],
            refresh: [
                "app/View/Components/**",
                "lang/**",
                "resources/lang/**",
                "resources/views/**",
                "resources/routes/**",
                "routes/**",
                "modules/**/Resources/lang/**",
                "modules/**/Resources/views/**/*.blade.php",
            ],
        }),
    ],
    resolve: {
        alias: {
            "~node_modules": path.resolve(__dirname, "node_modules"),
            "~vendor": path.resolve(__dirname, "vendor"),
        },
    },
});
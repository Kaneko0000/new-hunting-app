import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        // host: 'localhost',           // 明示的にホストを指定
        host: 'hunting-app.local',           // 明示的にホストを指定
        port: 5173,                  // デフォルトと同じでも明示が安心
        strictPort: true,           // 5173が使えないとエラーで落とす（自動変更しない）
        hmr: {
            // host: 'localhost',
            host: 'hunting-app.local',
            protocol: 'ws',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/custom.css',
                'resources/js/app.js',
                'resources/js/custom.js'
            ],
            refresh: true,
        }),
    ],
});

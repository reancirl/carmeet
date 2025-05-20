import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  build: {
    rollupOptions: {
      input: {
        // your existing entrypoints remain handled by the Laravel plugin
        // these keys here are just to instruct Rollup/Vite to copy them:
        manifest: resolve(__dirname, 'public/manifest.json'),
        'service-worker': resolve(__dirname, 'public/service-worker.js'),
      },
    },
  },
});

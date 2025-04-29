import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
  plugins: [
    vue(),
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
      refresh: [
        'resources/views/**',
        'routes/**',
        'resources/js/Pages/**',
        'resources/js/Components/**',
      ],
    }),
  ],
  server: {
    host: 'localhost',
    port: 5173,
    open: true, // ✅ Auto open browser when running npm run dev
    hmr: {
      host: 'localhost',
    },
  },
  build: {
    outDir: 'public/build', // ✅ Production build output
    manifest: true,
    rollupOptions: {
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
      ],
    },
  },
});

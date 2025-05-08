import vue from '@vitejs/plugin-vue2';
import { defineConfig } from 'vite';

export default defineConfig({
  plugins: [vue()],
  server: {
    port: 5174,
    proxy: {
      '/api': 'http://localhost:8000',
    '/sanctum': 'http://localhost:8000'
    }
  }
});

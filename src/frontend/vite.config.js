import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import { resolve } from 'path'
import { rm } from 'node:fs/promises'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue(), {
    name: "Cleaning assets folder",
    async buildStart() {
      await rm(resolve(__dirname, '../assets'), { recursive: true, force: true });
    }
  }],
  build: {
    outDir: "../",
  },
});

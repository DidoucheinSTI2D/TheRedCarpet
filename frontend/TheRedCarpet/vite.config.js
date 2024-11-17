import react from "@vitejs/plugin-react";
import path from "path";
import { defineConfig } from "vite";

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],
  resolve: {
    alias: {
      "@api": path.resolve(
        path.dirname(new URL(import.meta.url).pathname),
        "src/api"
      ),
    },
  },
});

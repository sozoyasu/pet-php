import { defineConfig, loadEnv } from "vite";
import liveReload from 'vite-plugin-live-reload';

export default {
    plugins: [
        liveReload([
            __dirname + '/resources/templates/**/*.php',
        ]),
    ],
    base: './',
    publicDir: false,
    build: {
        manifest: "manifest.json",
        outDir:  'public/assets',
        rollupOptions: {
            input: {
                js: './resources/js/app.js',
                css: './resources/css/app.css',
            },
            output: {
                entryFileNames: `js/app.js`,
                assetFileNames: ({name}) => {
                    if (/\.(gif|jpe?g|png)$/.test(name ?? '')){
                        return 'img/[name].[ext]';
                    }

                    if (/\.(svg)$/.test(name ?? '')){
                        return 'svg/[name].[ext]';
                    }

                    if (/\.css$/.test(name ?? '')) {
                        return 'css/app.[ext]';
                    }

                    return '[name].[ext]';
                },
            },
        },
    },
    server: {
        strictPort: true,
        port: 3000,
        host: '0.0.0.0',
        origin: 'http://localhost:3000',
        hmr: {
            clientPort: 3000,
            host: 'localhost',
        },
    }
}
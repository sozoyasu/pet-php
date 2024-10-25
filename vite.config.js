import { defineConfig, loadEnv } from "vite";
import liveReload from 'vite-plugin-live-reload';
import dotenv from 'dotenv';
import fs from 'fs';

Object.assign(process.env, dotenv.parse(fs.readFileSync(`${__dirname}/.env`)))
const port = process.env.VITE_PORT;
const host = process.env.VITE_HOST;
const http = process.env.VITE_HTTP;

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
        port: port,
        host: '0.0.0.0',
        origin: http + '://' + host + ':' + port,
        hmr: {
            clientPort: port,
            host: host,
        },
    }
}
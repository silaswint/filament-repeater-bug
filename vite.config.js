import { defineConfig, loadEnv } from 'vite'
import laravel from 'laravel-vite-plugin'
import path from 'path'

const config = {
  plugins: [
    laravel({
      input: ['resources/js/app.js'],
      refresh: true
    }),
  ]
}

/** @readme https://ddev.com/blog/working-with-vite-in-ddev/ */
if (process.env.DDEV_PRIMARY_URL && process.env.NODE_ENV === 'development') {
  const port = 5173
  const url = new URL(process.env.DDEV_PRIMARY_URL)
  url.port = port.toString()

  const origin = url.toString().replace(/\/$/, '')
  console.log('url for VITE:', origin)

  config.server = {
    // respond to all network requests:
    host: '0.0.0.0',
    port,
    strictPort: true,
    // Defines the origin of the generated asset URLs during development
    origin
  }
}
export default defineConfig(({ mode }) => {
  // remember, we don't have the ".env" file for staging and production, use ".github/workflows/deploy_staging.yml" instead
  process.env = { ...process.env, ...loadEnv(mode, process.cwd()) }
  return config
})

import { defineConfig } from 'vite';
import { resolve, dirname } from 'path';
import { fileURLToPath } from 'url';
import { readdirSync } from 'fs';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Helper to get all HTML files in events directory
const getEventEntries = () => {
    const eventsDir = resolve(__dirname, 'events');
    try {
        const files = readdirSync(eventsDir);
        const entries = {};
        files.forEach(file => {
            if (file.endsWith('.html')) {
                const name = file.replace('.html', '');
                // Correctly mapping for Vite output
                entries[`events/${name}`] = resolve(eventsDir, file);
            }
        });
        return entries;
    } catch (e) {
        return {};
    }
};

export default defineConfig({
    build: {
        rollupOptions: {
            input: {
                main: resolve(__dirname, 'index.html'),
                ...getEventEntries()
            }
        }
    }
});

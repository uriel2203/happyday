import { defineConfig } from 'vite';
import { resolve } from 'path';
import { readdirSync } from 'fs';

// Helper to get all HTML files in events directory
const getEventEntries = () => {
    const eventsDir = resolve(__dirname, 'events');
    try {
        const files = readdirSync(eventsDir);
        const entries = {};
        files.forEach(file => {
            if (file.endsWith('.html')) {
                const name = file.replace('.html', '');
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

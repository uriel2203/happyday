import fs from 'fs';
import axios from 'axios';

async function download(url, dest) {
    const res = await axios({
        url, method: 'GET', responseType: 'stream',
        headers: {
            'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/100.0.4896.75 Safari/537.36'
        }
    });
    return new Promise((resolve, reject) => {
        const stream = fs.createWriteStream(dest);
        res.data.pipe(stream);
        stream.on('finish', resolve);
        stream.on('error', reject);
    });
}

(async () => {
    try {
        if (!fs.existsSync('public/images')) { fs.mkdirSync('public/images', { recursive: true }); }
        await download("https://media.giphy.com/media/ICOgUNjpvO0PC/giphy.gif", "public/images/pleading.gif");
        await download("https://media.giphy.com/media/L95W4wv8nnb9K/giphy.gif", "public/images/crying.gif");
        await download("https://media.giphy.com/media/l8ooOxhcItowwLPuZn/giphy.gif", "public/images/hug.gif");
        console.log("Downloaded successfully");
    } catch (err) {
        console.error("Error", err.message);
    }
})();

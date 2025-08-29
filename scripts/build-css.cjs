const fs = require('fs');
const path = require('path');
const postcss = require('postcss');
const tailwind = require('@tailwindcss/postcss');
const autoprefixer = require('autoprefixer');
const rtlcss = require('rtlcss');

const inputPath = path.resolve(__dirname, '..', 'resources', 'css', 'app.css');
const outDir = path.resolve(__dirname, '..', 'public', 'css');
const outLtr = path.join(outDir, 'app.css');
const outRtl = path.join(outDir, 'app.rtl.css');

async function build() {
  try {
    const input = fs.readFileSync(inputPath, 'utf8');
    const result = await postcss([tailwind, autoprefixer]).process(input, {
      from: inputPath,
      to: outLtr,
      map: false,
    });

    fs.mkdirSync(outDir, { recursive: true });
    fs.writeFileSync(outLtr, result.css, 'utf8');
    console.log('Wrote', outLtr);

    // rtlcss may expose a processor with a `process` method
    let rtlOutput;
    if (typeof rtlcss === 'function') {
      rtlOutput = rtlcss(result.css);
    } else if (rtlcss && typeof rtlcss.process === 'function') {
      const res = rtlcss.process(result.css);
      rtlOutput = res && res.css ? res.css : res;
    } else {
      // fallback: try calling as function
      rtlOutput = rtlcss(result.css);
    }
    if (typeof rtlOutput !== 'string') rtlOutput = String(rtlOutput);
    fs.writeFileSync(outRtl, rtlOutput, 'utf8');
    console.log('Wrote', outRtl);
  } catch (err) {
    console.error(err);
    process.exit(1);
  }
}

build();

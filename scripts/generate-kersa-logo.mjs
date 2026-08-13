import { Resvg } from '@resvg/resvg-js';
import fs from 'node:fs/promises';
import path from 'node:path';

const outDir = path.resolve('public', 'branding');

const encodeSvg = (svg) => svg.replace(/\r\n/g, '\n');

const renderPng = async ({ filename, svg, width }) => {
    const resvg = new Resvg(encodeSvg(svg), {
        fitTo: {
            mode: 'width',
            value: width,
        },
        font: {
            fontDirs: [],
            loadSystemFonts: true,
        },
    });

    const pngData = resvg.render().asPng();
    await fs.writeFile(path.join(outDir, filename), pngData);
};

const defs = `
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="0">
        <stop offset="0" stop-color="#10b981"/>
        <stop offset="0.55" stop-color="#06b6d4"/>
        <stop offset="1" stop-color="#0ea5e9"/>
    </linearGradient>
    <linearGradient id="g2" x1="0" y1="1" x2="1" y2="0">
        <stop offset="0" stop-color="#34d399"/>
        <stop offset="0.6" stop-color="#22d3ee"/>
        <stop offset="1" stop-color="#38bdf8"/>
    </linearGradient>
    <pattern id="kawung" width="80" height="80" patternUnits="userSpaceOnUse">
        <circle cx="20" cy="20" r="10" fill="none" stroke="#0f172a" stroke-opacity="0.22" stroke-width="2"/>
        <circle cx="60" cy="20" r="10" fill="none" stroke="#0f172a" stroke-opacity="0.18" stroke-width="2"/>
        <circle cx="20" cy="60" r="10" fill="none" stroke="#0f172a" stroke-opacity="0.18" stroke-width="2"/>
        <circle cx="60" cy="60" r="10" fill="none" stroke="#0f172a" stroke-opacity="0.22" stroke-width="2"/>
        <path d="M0 40H80M40 0V80" stroke="#0f172a" stroke-opacity="0.08" stroke-width="2"/>
    </pattern>
`;

const wordmarkSvg = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1600 420">
    <defs>${defs}</defs>
    <g transform="translate(800 235)">
        <text x="0" y="0" text-anchor="middle"
            font-family="Poppins, Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="220" font-weight="700" letter-spacing="18"
            fill="url(#g)">KERSA</text>
        <text x="0" y="0" text-anchor="middle"
            font-family="Poppins, Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="220" font-weight="700" letter-spacing="18"
            fill="url(#kawung)" opacity="0.22">KERSA</text>
        <path d="M-530 96H530" stroke="url(#g2)" stroke-width="10" stroke-linecap="round" opacity="0.22"/>
    </g>
</svg>
`;

const kerisPath = `
M34 10
C46 34 38 52 50 74
C60 92 60 110 50 128
C44 140 42 156 52 170
C62 184 60 202 46 216
C38 226 34 236 36 250
C40 272 34 296 18 310
C10 316 8 326 12 336
C18 352 18 368 10 386
L34 396
C60 368 62 336 50 310
C76 286 82 254 66 226
C92 198 92 170 74 144
C100 118 98 88 78 62
C92 38 86 18 70 6
L34 10Z
`;

const wordmarkIconSvg = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1800 420">
    <defs>${defs}</defs>
    <g transform="translate(165 30)">
        <path d="${kerisPath}" fill="url(#g)" opacity="0.95"/>
        <path d="${kerisPath}" fill="url(#kawung)" opacity="0.16"/>
        <path d="M34 10L70 6" stroke="#0f172a" stroke-opacity="0.12" stroke-width="6" stroke-linecap="round"/>
    </g>
    <g transform="translate(520 250)">
        <text x="0" y="0"
            font-family="Poppins, Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="210" font-weight="700" letter-spacing="16"
            fill="url(#g)">KERSA</text>
        <text x="0" y="0"
            font-family="Poppins, Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="210" font-weight="700" letter-spacing="16"
            fill="url(#kawung)" opacity="0.22">KERSA</text>
        <path d="M0 90H980" stroke="url(#g2)" stroke-width="10" stroke-linecap="round" opacity="0.22"/>
    </g>
</svg>
`;

const monogramSvg = `
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1024 1024">
    <defs>${defs}</defs>
    <rect x="92" y="92" width="840" height="840" rx="220" fill="url(#g2)" opacity="0.16"/>
    <rect x="120" y="120" width="784" height="784" rx="205" fill="none" stroke="url(#g)" stroke-width="18"/>
    <rect x="150" y="150" width="724" height="724" rx="190" fill="url(#kawung)" opacity="0.12"/>
    <g transform="translate(512 610)">
        <text x="0" y="0" text-anchor="middle"
            font-family="Poppins, Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="520" font-weight="700" letter-spacing="0"
            fill="url(#g)">K</text>
        <text x="0" y="0" text-anchor="middle"
            font-family="Poppins, Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="520" font-weight="700"
            fill="url(#kawung)" opacity="0.18">K</text>
    </g>
    <g transform="translate(500 230) scale(1.55)" opacity="0.92">
        <path d="${kerisPath}" fill="url(#g)"/>
    </g>
    <g transform="translate(512 900)">
        <text x="0" y="0" text-anchor="middle"
            font-family="Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Arial"
            font-size="66" font-weight="700" letter-spacing="14"
            fill="#0f172a" opacity="0.7">KERSA</text>
    </g>
</svg>
`;

await fs.mkdir(outDir, { recursive: true });

await Promise.all([
    renderPng({ filename: 'kersa-wordmark.png', svg: wordmarkSvg, width: 1400 }),
    renderPng({ filename: 'kersa-wordmark-keris.png', svg: wordmarkIconSvg, width: 1600 }),
    renderPng({ filename: 'kersa-monogram.png', svg: monogramSvg, width: 1024 }),
]);

process.stdout.write(`Generated logos in: ${outDir}\n`);

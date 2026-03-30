// Robust PDF generator using local Chrome headless — no external npm deps
const { spawnSync } = require('child_process');
const fs = require('fs');
const path = require('path');
const os = require('os');

const chromePath = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const artifactsDir = 'C:\\Users\\diosi\\.gemini\\antigravity\\brain\\9c451e14-65f6-4ec6-85ef-fce667a88f87';

function mdToHtml(md, title) {
  const lines = md.split('\n');
  let html = '';
  let i = 0;
  let inList = false;
  let listType = '';
  let inTable = false;
  let tableHeader = false;

  function closeList() {
    if (inList) { html += `</${listType}>\n`; inList = false; listType = ''; }
  }
  function closeTable() {
    if (inTable) { html += `</tbody></table>\n`; inTable = false; tableHeader = false; }
  }

  while (i < lines.length) {
    let line = lines[i];

    // ── Fenced code block ──
    if (line.match(/^```/)) {
      closeList(); closeTable();
      const lang = line.replace(/^```/, '').trim();
      let code = '';
      i++;
      while (i < lines.length && !lines[i].match(/^```/)) {
        code += escHtml(lines[i]) + '\n';
        i++;
      }
      html += `<pre class="lang-${lang || 'text'}"><code>${code}</code></pre>\n`;
      i++; continue;
    }

    // ── Headings ──
    const hm = line.match(/^(#{1,4}) (.+)$/);
    if (hm) {
      closeList(); closeTable();
      const lvl = hm[1].length;
      html += `<h${lvl}>${inline(hm[2])}</h${lvl}>\n`;
      i++; continue;
    }

    // ── HR ──
    if (line.match(/^---+$/)) {
      closeList(); closeTable();
      html += '<hr>\n';
      i++; continue;
    }

    // ── Blockquote / Alert ──
    if (line.match(/^> /)) {
      closeList(); closeTable();
      const content = line.replace(/^> /, '');
      const alertMatch = content.match(/^\[!(NOTE|TIP|IMPORTANT|WARNING|CAUTION)\]$/);
      if (alertMatch && lines[i+1] && lines[i+1].match(/^> /)) {
        const type = alertMatch[1].toLowerCase();
        const icons = { note: '📝', tip: '💡', important: '⚠️', warning: '🚨', caution: '🔴' };
        const nextContent = lines[i+1].replace(/^> /, '');
        html += `<div class="alert ${type}"><strong>${icons[type]} ${alertMatch[1]}: </strong>${inline(nextContent)}</div>\n`;
        i += 2;
      } else {
        html += `<blockquote>${inline(content)}</blockquote>\n`;
        i++;
      }
      continue;
    }

    // ── Table ──
    if (line.match(/^\|/)) {
      // Check if separator line (|---|---|)
      if (line.match(/^\|[\s\-\|:]+\|$/)) {
        if (!tableHeader) { tableHeader = true; }
        i++; continue;
      }
      const cells = line.split('|').filter((c, idx, a) => idx > 0 && idx < a.length - 1);
      if (!inTable) {
        closeList();
        html += '<table>\n';
        // First row = header
        html += '<thead><tr>' + cells.map(c => `<th>${inline(c.trim())}</th>`).join('') + '</tr></thead>\n<tbody>\n';
        inTable = true;
        tableHeader = false;
      } else {
        html += '<tr>' + cells.map(c => `<td>${inline(c.trim())}</td>`).join('') + '</tr>\n';
      }
      i++; continue;
    } else {
      closeTable();
    }

    // ── Unordered list ──
    const ulm = line.match(/^( *)[-*] (.+)$/);
    if (ulm) {
      const indent = ulm[1].length;
      const content = inline(ulm[2]);
      if (!inList) {
        html += '<ul>\n'; inList = true; listType = 'ul';
      }
      if (indent >= 2) {
        html += `<li class="sub">${content}</li>\n`;
      } else {
        html += `<li>${content}</li>\n`;
      }
      i++; continue;
    }

    // ── Ordered list ──
    const olm = line.match(/^\d+\. (.+)$/);
    if (olm) {
      if (!inList || listType !== 'ol') {
        closeList();
        html += '<ol>\n'; inList = true; listType = 'ol';
      }
      html += `<li>${inline(olm[1])}</li>\n`;
      i++; continue;
    }

    // ── Blank line ──
    if (line.trim() === '') {
      closeList(); closeTable();
      html += '<br>\n';
      i++; continue;
    }

    // ── Normal paragraph ──
    closeList(); closeTable();
    html += `<p>${inline(line)}</p>\n`;
    i++;
  }

  closeList(); closeTable();

  return `<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<title>${title}</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; font-size: 13px; color: #1e293b; line-height: 1.75; padding: 45px 55px; max-width: 960px; margin: auto; }
  h1 { font-size: 24px; color: #0f172a; border-bottom: 3px solid #10b981; padding-bottom: 8px; margin: 30px 0 14px; page-break-after: avoid; }
  h2 { font-size: 17px; color: #1e40af; margin: 22px 0 10px; border-left: 4px solid #3b82f6; padding-left: 10px; page-break-after: avoid; }
  h3 { font-size: 14.5px; color: #334155; margin: 16px 0 8px; page-break-after: avoid; }
  h4 { font-size: 12.5px; color: #64748b; margin: 12px 0 6px; text-transform: uppercase; letter-spacing: 0.05em; page-break-after: avoid; }
  p { margin: 6px 0; }
  strong { font-weight: 700; color: #0f172a; }
  em { font-style: italic; color: #475569; }
  code { background: #f1f5f9; border: 1px solid #e2e8f0; padding: 1px 5px; border-radius: 3px; font-family: Consolas, monospace; font-size: 11.5px; color: #c026d3; }
  pre { background: #0f172a; color: #e2e8f0; padding: 14px 18px; border-radius: 8px; margin: 12px 0; overflow-x: auto; page-break-inside: avoid; white-space: pre-wrap; word-break: break-all; }
  pre code { background: none; border: none; color: #e2e8f0; font-size: 11.5px; padding: 0; white-space: pre-wrap; }
  table { width: 100%; border-collapse: collapse; margin: 12px 0 16px; font-size: 12px; page-break-inside: avoid; }
  th { background: #1e293b; color: white; padding: 8px 11px; text-align: left; font-weight: 700; font-size: 11.5px; }
  td { border: 1px solid #e2e8f0; padding: 7px 11px; }
  tr:nth-child(even) td { background: #f8fafc; }
  ul, ol { margin: 6px 0 8px 24px; }
  li { margin: 3px 0; }
  li.sub { margin-left: 18px; list-style-type: circle; }
  hr { border: none; border-top: 1px solid #e2e8f0; margin: 18px 0; }
  blockquote { border-left: 4px solid #94a3b8; margin: 10px 0; padding: 8px 14px; background: #f8fafc; color: #475569; }
  .alert { padding: 10px 15px; border-radius: 6px; margin: 12px 0; font-size: 12.5px; page-break-inside: avoid; }
  .alert.note      { background: #eff6ff; border-left: 4px solid #3b82f6; }
  .alert.important { background: #fff7ed; border-left: 4px solid #f97316; }
  .alert.warning   { background: #fef2f2; border-left: 4px solid #ef4444; }
  .alert.tip       { background: #f0fdf4; border-left: 4px solid #22c55e; }
  .lang-bash, .lang-php, .lang-sql { border-top: 3px solid #10b981; }
  @page { margin: 15mm 15mm; }
</style>
</head>
<body>
${html}
</body>
</html>`;
}

function escHtml(s) {
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}

function inline(text) {
  return text
    // Bold + italic
    .replace(/\*\*\*(.+?)\*\*\*/g, '<strong><em>$1</em></strong>')
    // Bold
    .replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>')
    // Italic
    .replace(/\*(.+?)\*/g, '<em>$1</em>')
    // Inline code
    .replace(/`([^`]+)`/g, (_, c) => `<code>${escHtml(c)}</code>`)
    // Links [text](url)
    .replace(/\[([^\]]+)\]\(([^)]+)\)/g, '<a href="$2">$1</a>')
    // Escape remaining HTML
    .replace(/(?<!<[^>]*)&(?![^;]+;)/g, '&amp;');
}

const docs = [
  { md: 'readme_tecnico.md',   pdf: 'readme_tecnico.pdf',   title: 'GHS — Documentação Técnica' },
  { md: 'manual_utilizador.md', pdf: 'manual_utilizador.pdf', title: 'GHS — Manual do Utilizador' },
  { md: 'resumo_executivo.md', pdf: 'resumo_executivo.pdf', title: 'GHS — Resumo Executivo' },
];

for (const doc of docs) {
  const mdPath   = path.join(artifactsDir, doc.md);
  const htmlPath = path.join(os.tmpdir(), doc.md.replace('.md', '.html'));
  const pdfPath  = path.join(artifactsDir, doc.pdf);
  const docsPdfPath = path.join('C:\\xampp\\htdocs\\green\\docs', doc.pdf);

  const mdContent = fs.readFileSync(mdPath, 'utf8');
  const htmlContent = mdToHtml(mdContent, doc.title);
  fs.writeFileSync(htmlPath, htmlContent, 'utf8');

  console.log(`🔄 Gerando ${doc.pdf}...`);
  const result = spawnSync(chromePath, [
    '--headless=new',
    '--no-sandbox',
    '--disable-gpu',
    '--disable-extensions',
    '--disable-dev-shm-usage',
    `--print-to-pdf=${pdfPath}`,
    '--print-to-pdf-no-header',
    `file:///${htmlPath.replace(/\\/g, '/')}`
  ], { timeout: 30000 });

  if (result.status === 0) {
    fs.copyFileSync(pdfPath, docsPdfPath);
    console.log(`✅ Gerado: ${doc.pdf}`);
  } else {
    console.error(`❌ Erro: ${doc.pdf}`, result.stderr?.toString().slice(0, 200));
  }
}

<?php
// README Técnico / Developer Guide FMD v1.0 — Faculdade Moderna de Direito
?>
<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title>FMD — Developer Guide & Manual Técnico v1.0</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0b1120;
            --accent: #1e3a8a;
            --accent-green: #059669;
            --light: #f8fafc;
            --border: #e2e8f0;
            --text: #334155;
            --muted: #64748b;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; color: var(--text); background: #fff; padding: 40px 60px; line-height: 1.6; font-size: 13px; }

        .cover { display: flex; align-items: flex-start; justify-content: space-between; border-bottom: 2px solid var(--border); padding-bottom: 25px; margin-bottom: 35px; }
        .cover-left h1 { font-size: 26px; font-weight: 700; color: var(--primary); margin: 6px 0; }
        .cover-left p { color: var(--muted); font-size: 13px; }
        .cover-right { text-align: right; font-size: 12px; color: var(--muted); }
        .cover-right .version { display: inline-block; background: var(--light); border: 1px solid var(--border); color: var(--primary); padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; margin-bottom: 6px; }

        h2 { font-size: 16px; font-weight: 700; color: var(--primary); margin: 30px 0 12px; padding-bottom: 6px; border-bottom: 2px solid var(--accent); }
        h3 { font-size: 14px; font-weight: 600; color: var(--accent); margin: 20px 0 10px; }
        p { margin-bottom: 10px; text-align: justify; }
        ul, ol { padding-left: 20px; margin-bottom: 12px; }

        table { width: 100%; border-collapse: collapse; margin: 15px 0 25px; font-size: 12px; border: 1px solid var(--border); }
        thead th { background: var(--light); color: var(--primary); padding: 10px 12px; text-align: left; font-weight: 600; border-bottom: 1px solid var(--border); }
        tbody td { border-bottom: 1px solid var(--border); padding: 8px 12px; vertical-align: top; }

        pre { font-family: 'JetBrains Mono', monospace; background: #0f172a; color: #f8fafc; padding: 14px; border-radius: 6px; font-size: 11px; line-height: 1.5; margin: 15px 0; overflow-x: auto; }
        code { font-family: 'JetBrains Mono', monospace; background: var(--light); padding: 2px 5px; border-radius: 4px; font-size: 11px; color: #b91c1c; border: 1px solid var(--border); }

        .footer { margin-top: 40px; padding-top: 15px; font-size: 11px; color: var(--muted); display: flex; justify-content: space-between; border-top: 1px solid var(--border); }

        @media print {
            @page { margin: 0.5cm; }
            body { padding: 30px 40px; }
        }
    </style>
</head>

<body>

    <div class="cover">
        <div class="cover-left">
            <img src="../img/faculdade.png" alt="Faculdade Moderna de Direito" style="height: 60px; border-radius: 6px; margin-bottom: 20px;">
            <h1>Developer Guide & Manual Técnico — FMD</h1>
            <p>Documentação de Arquitetura, Stack, Segurança, Base de Dados e Manutenção</p>
        </div>
        <div class="cover-right">
            <div class="version">v1.0 FMD</div><br>
            <strong>Stack:</strong> PHP 8.x + MySQL PDO + MVC<br>
            <strong>Instituição:</strong> Faculdade Moderna de Direito
        </div>
    </div>

    <h2>1. Visão Geral da Arquitetura</h2>
    <p>O sistema da Faculdade Moderna de Direito (FMD) foi construído segundo o padrão <strong>MVC (Model-View-Controller)</strong> puro em <strong>PHP 8.2+</strong>, sem dependência de frameworks externos como Laravel ou Symfony. A persistência é gerida via <strong>PDO (PHP Data Objects)</strong> com suporte a MySQL/MariaDB.</p>

    <h2>2. Estrutura de Diretórios do Projeto</h2>
    <pre>
faculdade_moderna_direito/
├── app/
│   ├── controllers/      # Controladores MVC (Auth, Admin, Estudante, Professor, etc.)
│   ├── helpers/          # Utilitários (Mailer.php, Captcha.php, etc.)
│   ├── logs/             # Logs centralizados de erros e auditoria (error.log)
│   ├── models/           # Modelos de Dados PDO (Academico, Nota, Matricula, User, etc.)
│   └── views/            # Visões HTML/PHP (auth, admin, estudante, professor, shared)
├── core/
│   ├── App.php           # Motor de Roteamento e Inicialização (Bootstrap)
│   ├── Controller.php    # Controller Base (Renderização de views e verificação CSRF)
│   ├── Database.php      # Singleton PDO com Prepared Statements
│   └── config.php        # Configurações Globais Institucionais (FMD)
├── database/
│   ├── migrations/       # Scripts SQL de evolução de esquema
│   └── seeds/            # Dados de teste e inicialização
├── docs/                 # Documentação oficial (PDF exporters)
├── img/                  # Logotipos e recursos visuais institucionais (faculdade.png)
├── public/               # Ponto de entrada público e assets estáticos (CSS, JS, uploads)
├── index.php             # Front Controller único
└── styles.css            # Design System em Vanilla CSS
    </pre>

    <h2>3. Configurações Globais (`core/config.php`)</h2>
    <pre>
// Identidade Institucional FMD
define('APP_NAME',       'Faculdade Moderna de Direito');
define('APP_SHORT_NAME', 'FMD');

// Base de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'ghsespf_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// Segurança & Prazos
define('SESSION_LIFETIME',       1800);          // 30 min inatividade
define('CSRF_NAME',              'fmd_csrf_token');
define('MATRICULA_PRAZO_HORAS',  48);            // 48 horas regulamentares
define('REGRA_3_NEGATIVAS_ATIVA',true);
define('LIMITE_NEGATIVAS',       3);
    </pre>

    <h2>4. Camada de Segurança (Security Hardening)</h2>
    <table>
        <thead>
            <tr>
                <th>Ameaça / Vetor</th>
                <th>Mecanismo de Proteção Implementado</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>CSRF (Cross-Site Request Forgery)</strong></td>
                <td>Token criptográfico único gerado por sessão (<code>$_SESSION['csrf_token']</code>) e validado obrigatoriamente no <code>Controller::verifyCsrfToken()</code> em todos os métodos POST.</td>
            </tr>
            <tr>
                <td><strong>XSS (Cross-Site Scripting)</strong></td>
                <td>Sanitização sistemática de inputs via <code>FILTER_SANITIZE_SPECIAL_CHARS</code> e escaping de saída com <code>htmlspecialchars()</code> em todas as views.</td>
            </tr>
            <tr>
                <td><strong>SQL Injection</strong></td>
                <td>Uso exclusivo de PDO Prepared Statements com bound parameters em 100% das consultas à base de dados.</td>
            </tr>
            <tr>
                <td><strong>IDOR (Insecure Direct Object Reference)</strong></td>
                <td>Validação estrita de propriedade (<code>user_id</code> da sessão) antes de servir arquivos ou visualizar registros sensíveis.</td>
            </tr>
            <tr>
                <td><strong>Brute Force</strong></td>
                <td>Bloqueio temporário de conta no modelo <code>User.php</code> após 5 tentativas falhadas sucessivas.</td>
            </tr>
        </tbody>
    </table>

    <h2>5. Motor Académico de Avaliações (`Academico.php` / `Nota.php`)</h2>
    <p>O cálculo das pautas opera sobre 5 tipos de avaliação registados na tabela <code>tipos_avaliacao</code>:</p>
    <ul>
        <li><code>ID 1 (AC1):</code> Teste Escrito / Teoria Geral</li>
        <li><code>ID 2 (AC2):</code> Resolução de Casos Práticos</li>
        <li><code>ID 3 (AC3):</code> Redação de Peça Processual / Pesquisa</li>
        <li><code>ID 4 (AC4):</code> Participação nas Aulas / Simulações</li>
        <li><code>ID 5 (Exame):</code> Exame Final Escrito / Oral</li>
    </ul>

    <pre>
// Algoritmo de Cálculo Centralizado (Academico.php)
$ac_total = $notas[1] + $notas[2] + $notas[3] + $notas[4]; // Máx 20 valores
$nota_final = ($exame !== null) ? ($ac_total + $exame) / 2 : null;

if ($nota_final >= 12) {
    $status = 'Aprovado';
} elseif ($nota_final >= 8) {
    $status = 'Recurso';
} else {
    $status = 'Reprovado';
}
    </pre>

    <h2>6. Deploy e Manutenção</h2>
    <p><strong>Requisitos de Servidor:</strong> Apache 2.4+ com <code>mod_rewrite</code> ativo, PHP 8.2+, MySQL 8.0 / MariaDB 10.4+.</p>
    <p><strong>Instalação:</strong> Clonar o repositório no diretório de publicação do servidor, importar as migrations SQL em <code>/database/migrations/</code> e configurar o ficheiro <code>core/config.php</code> conforme as credenciais de produção.</p>

    <div class="footer">
        <span>&copy; 2026 Faculdade Moderna de Direito (FMD). Developer Guide v1.0.</span>
        <span>Manual Técnico</span>
    </div>

</body>
</html>

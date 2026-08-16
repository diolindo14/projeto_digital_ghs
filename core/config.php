<?php
/**
 * Configurações Gerais do Sistema — Faculdade Moderna de Direito (FMD)
 *
 * NOTA HISTÓRICA: Este sistema foi originalmente desenvolvido para a
 * Green Hard & Soft (GHS) e migrado para a FMD em Agosto de 2026.
 */

// ─── Identidade Institucional ────────────────────────────────────────────────
define('APP_NAME',       'Faculdade Moderna de Direito');
define('APP_SHORT_NAME', 'FMD');

// ─── Configurações da Base de Dados ──────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'ghsespf_db');   // [A DEFINIR EM PRODUÇÃO]
define('DB_USER', 'root');
define('DB_PASS', '');

// ─── URL do Sistema ───────────────────────────────────────────────────────────
// Ajuste conforme o ambiente real de deployment.
define('URL_ROOT', '/faculdade_moderna_direito');

// ─── Configurações de Segurança ───────────────────────────────────────────────
define('SESSION_LIFETIME', 1800);          // 30 minutos de inatividade
define('CSRF_NAME',        'fmd_csrf_token');

// ─── Regras Académicas (Configuráveis) ───────────────────────────────────────
define('MATRICULA_PRAZO_HORAS',      48);  // Prazo para submeter matrícula após aprovação
define('REGRA_3_NEGATIVAS_ATIVA',  true);  // Activar/desactivar regra das 3 negativas
define('LIMITE_NEGATIVAS',            3);  // Número máximo de negativas permitido

// ─── Notações de Avaliação ────────────────────────────────────────────────────
define('NOTA_APROVACAO',  12);   // Nota mínima para aprovação directa
define('NOTA_RECURSO',     8);   // Nota mínima para acesso a recurso
// Nota < NOTA_RECURSO → Reprovado

// ─── Configurações de Upload ──────────────────────────────────────────────────
define('MAX_FILE_SIZE',       5 * 1024 * 1024);  // 5 MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'pdf']);

// ─── Email Institucional ──────────────────────────────────────────────────────
// [VALIDAÇÃO INSTITUCIONAL NECESSÁRIA] — substituir pelo email real da FMD
define('MAIL_FROM', 'no-reply@fmd.edu');

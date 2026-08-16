<?php
/**
 * Migração: Adicionar coluna foto_perfil à tabela utilizadores
 * + criar directório de uploads para fotos de perfil
 */
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();

echo "=== MIGRAÇÃO: foto_perfil ===\n\n";

// 1. Verificar se já existe
$cols = $db->query("SHOW COLUMNS FROM utilizadores LIKE 'foto_perfil'")->fetchAll();
if (empty($cols)) {
    $db->exec("ALTER TABLE utilizadores ADD COLUMN foto_perfil VARCHAR(255) NULL DEFAULT NULL COMMENT 'Caminho relativo da foto de perfil (Admin/Secretaria/outros)'");
    echo "[OK] Coluna foto_perfil adicionada à tabela utilizadores.\n";
} else {
    echo "[SKIP] Coluna foto_perfil já existe em utilizadores.\n";
}

// 2. Verificar colunas estudantes e professores
$e = $db->query("SHOW COLUMNS FROM estudantes LIKE 'foto_perfil'")->fetchAll();
$p = $db->query("SHOW COLUMNS FROM professores LIKE 'foto_perfil'")->fetchAll();
echo "[OK] estudantes.foto_perfil: " . (empty($e) ? "AUSENTE" : "EXISTS") . "\n";
echo "[OK] professores.foto_perfil: " . (empty($p) ? "AUSENTE" : "EXISTS") . "\n";

// 3. Criar directório de uploads
$uploadDir = __DIR__ . '/../../public/uploads/fotos_perfil';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    echo "[OK] Directório public/uploads/fotos_perfil/ criado.\n";
} else {
    echo "[SKIP] Directório public/uploads/fotos_perfil/ já existe.\n";
}

echo "\n=== MIGRAÇÃO CONCLUÍDA ===\n";

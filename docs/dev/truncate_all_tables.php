<?php
/**
 * Truncate Completo de Todas as Tabelas da Base de Dados
 * Faculdade Moderna de Direito (FMD)
 */
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Database.php';

$db = Database::getInstance();

echo "======================================================\n";
echo "       FMD - TRUNCATE COMPLETO DA BASE DE DADOS      \n";
echo "======================================================\n\n";

try {
    // 1. Desativar verificação de chaves estrangeiras
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    echo "[INFO] Verificação de Foreign Keys desativada (FOREIGN_KEY_CHECKS = 0).\n\n";

    // 2. Obter todas as tabelas
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

    $truncatedCount = 0;
    foreach ($tables as $table) {
        $db->exec("TRUNCATE TABLE `$table`");
        echo "[OK] Tabela `$table` truncada com sucesso.\n";
        $truncatedCount++;
    }

    // 3. Reativar verificação de chaves estrangeiras
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "\n[INFO] Verificação de Foreign Keys reativada (FOREIGN_KEY_CHECKS = 1).\n";

    // 4. Inserir Utilizador Administrador Padrão para Acesso ao Sistema
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $db->prepare("
        INSERT INTO utilizadores (nome_completo, email, senha, tipo, status, data_criacao)
        VALUES ('Direção FMD', 'direcao@fmd.edu', :senha, 'admin', 'ativo', NOW())
    ");
    $stmt->execute([':senha' => $adminPassword]);
    $adminId = $db->lastInsertId();

    // Inserir registo correspondente na tabela administradores
    $stmtAdmin = $db->prepare("
        INSERT INTO administradores (utilizador_id, cargo, telefone)
        VALUES (:uid, 'Administrador', '000000000')
    ");
    $stmtAdmin->execute([':uid' => $adminId]);

    echo "\n[OK] Utilizador Administrador Padrão criado com sucesso:\n";
    echo "     - Email: direcao@fmd.edu\n";
    echo "     - Password: admin123\n";

    echo "\n======================================================\n";
    echo " SUCESSO: Total de $truncatedCount tabelas truncadas.\n";
    echo "======================================================\n";

} catch (Exception $e) {
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");
    echo "\n[ERRO] Falha ao executar truncate: " . $e->getMessage() . "\n";
}

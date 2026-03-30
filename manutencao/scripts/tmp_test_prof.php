<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 1. Criar Utilizador
    $stmt = $db->prepare("INSERT INTO utilizadores (nome_completo, email, senha, tipo, status) VALUES (:nome, :email, :senha, 'professor', 'ativo')");
    $stmt->execute([
        ':nome' => 'Prof Test Script',
        ':email' => 'test' . rand() . '@ghs.com',
        ':senha' => '123456'
    ]);
    $userId = $db->lastInsertId();

    // 2. Criar Perfil Professor
    $stmt = $db->prepare("INSERT INTO professores (utilizador_id, bi, telefone, especialidade, grau_academico, data_contratacao) VALUES (:uid, :bi, :tel, :esp, :grau, :data_con)");
    $stmt->execute([
        ':uid' => $userId,
        ':bi' => '0000000',
        ':tel' => '0000000',
        ':esp' => 'Geral',
        ':grau' => 'Mestre',
        ':data_con' => date('Y-m-d')
    ]);
    
    echo "SUCCESS";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}

<?php
require_once 'core/Database.php';
require_once 'app/models/Nota.php';

try {
    $notaModel = new Nota();
    // Test parameters (random IDs)
    $res = $notaModel->registrarFeedback(1, 1, 1, 'Concordado', 'Teste de sistema');
    echo "Resultado: " . ($res ? "Sucesso" : "Falha") . "\n";
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
} catch (Error $e) {
    echo "Erro Fatal: " . $e->getMessage() . "\n";
}

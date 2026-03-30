<?php
require_once 'core/Database.php';
$db = Database::getInstance();
$results = [];

try {
    // Check user 13
    $stmt = $db->prepare("SELECT id, nome_completo, tipo FROM utilizadores WHERE id = ?");
    $stmt->execute([13]);
    $results['user_13'] = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check all professors
    $stmt = $db->query("SELECT p.id as prof_id, u.id as user_id, u.nome_completo, u.tipo FROM professores p JOIN utilizadores u ON p.utilizador_id = u.id");
    $results['professors'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any attendance records for these professors
    $stmt = $db->query("SELECT professor_id, COUNT(*) as count FROM assiduidade_professores GROUP BY professor_id");
    $results['attendance_counts'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $results['error'] = $e->getMessage();
}

echo json_encode($results, JSON_PRETTY_PRINT);

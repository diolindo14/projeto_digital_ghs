<?php
require_once 'core/Database.php';

$db = Database::getInstance();
$results = [];

try {
    $stmt = $db->query("DESCRIBE assiduidade_professores");
    $results['schema'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $db->query("SELECT COUNT(*) as count FROM assiduidade_professores");
    $results['count'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt = $db->query("SELECT * FROM assiduidade_professores LIMIT 5");
    $results['samples'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if there are any records missing 'marcado_por' or 'professor_id'
    $stmt = $db->query("SELECT COUNT(*) as count FROM assiduidade_professores WHERE marcado_por IS NULL OR professor_id IS NULL");
    $results['null_checks'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Check if the joins in the query work
    $query = "
        SELECT ap.id
        FROM assiduidade_professores ap
        INNER JOIN turmas t ON ap.turma_id = t.id
        INNER JOIN disciplinas d ON ap.disciplina_id = d.id
        INNER JOIN utilizadores u_admin ON ap.marcado_por = u_admin.id
    ";
    $stmt = $db->query($query);
    $results['join_count'] = $stmt->rowCount();

} catch (Exception $e) {
    $results['error'] = $e->getMessage();
}

echo json_encode($results, JSON_PRETTY_PRINT);

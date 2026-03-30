<?php
require_once 'core/Database.php';
$db = Database::getInstance();

echo "Verificando Horários sem Professor ou com ID de Teste (12)...\n";

$stmt = $db->query("SELECT h.id, t.codigo as turma, d.nome as disciplina, h.professor_id 
                    FROM horarios h 
                    JOIN turmas t ON h.turma_id = t.id 
                    JOIN disciplinas d ON h.disciplina_id = d.id 
                    WHERE h.professor_id IS NULL OR h.professor_id = 12");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    echo "Nenhum horário com problemas encontrado.\n";
} else {
    echo "Encontrados " . count($results) . " horários pendentes:\n";
    foreach(array_slice($results, 0, 20) as $row) {
        echo "  - " . $row['turma'] . " | " . $row['disciplina'] . " (Prof: " . ($row['professor_id'] ?? 'NULL') . ")\n";
    }
}
?>

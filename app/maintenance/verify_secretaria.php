<?php
session_start();
$_SESSION['user_id'] = 13; // Simulating Admin/Staff "Rebeca"
$_SESSION['user_role'] = 'secretaria';
$_SESSION['user_name'] = 'Rebeca';

require_once 'core/Controller.php';
require_once 'core/Database.php';
// Autoload models manually for the script
require_once 'app/models/Matricula.php';
require_once 'app/models/Pagamento.php';
require_once 'app/models/Comunicado.php';
require_once 'app/models/DashboardModel.php';
require_once 'app/models/Estudante.php';

class MockController extends Controller {
    public function get_data() {
        $matriculaModel = new Matricula();
        $pagamentoModel = new Pagamento();
        $comunicadoModel = new Comunicado();
        $dashboardModel = new DashboardModel();
        $estudanteModel = new Estudante();

        $data = [
            'stats' => $dashboardModel->getSecretariaStats(),
            'matriculas_count' => count($matriculaModel->getPendingEnrollments()),
            'pagamentos_count' => count($pagamentoModel->getAll()),
            'comunicados_count' => count($comunicadoModel->getAll()),
            'estudantes_count' => count($estudanteModel->getAllStudents())
        ];
        return $data;
    }
}

$mock = new MockController();
echo json_encode($mock->get_data(), JSON_PRETTY_PRINT);

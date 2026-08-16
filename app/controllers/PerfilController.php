<?php
/**
 * PerfilController — Controlador Centralizado de Fotografia de Perfil
 *
 * Gere o upload, atualização e remoção da fotografia de perfil
 * para TODOS os utilizadores autenticados, independentemente do portal:
 *   - Portal do Estudante  (role: aluno/estudante  → tabela: estudantes)
 *   - Portal do Professor  (role: professor          → tabela: professores)
 *   - Portal Admin         (role: admin              → tabela: utilizadores)
 *   - Portal Secretaria    (role: secretaria         → tabela: utilizadores)
 *
 * URL base: /perfil
 * Endpoints:
 *   POST /perfil/uploadFoto   → processa o upload
 *   POST /perfil/removeFoto   → remove a foto actual
 */
class PerfilController extends Controller {

    /** @var string Directório raiz de uploads de fotos de perfil (relativo à raiz do projecto) */
    const UPLOAD_DIR = 'public/uploads/fotos_perfil/';

    /** @var int Tamanho máximo do ficheiro em bytes (3 MB) */
    const MAX_SIZE = 3 * 1024 * 1024;

    /** @var array Extensões permitidas */
    const ALLOWED_EXT = ['jpg', 'jpeg', 'png', 'webp'];

    /** @var array MIME types permitidos */
    const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp'];

    public function __construct() {
        parent::__construct();
        // Qualquer utilizador autenticado pode aceder
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/auth');
            exit;
        }
    }

    /**
     * Processa o upload da fotografia de perfil.
     * Valida o ficheiro, gera um nome único e actualiza a tabela correcta
     * conforme o papel (role) do utilizador.
     */
    public function uploadFoto() {
        $this->verifyCsrfToken();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['foto_perfil'])) {
            $this->redirectBack('error=no_file');
        }

        $file   = $_FILES['foto_perfil'];
        $userId = (int)$_SESSION['user_id'];
        $role   = $_SESSION['user_role'] ?? '';

        // --- Validação 1: Erro de upload do PHP ---
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->redirectBack('error=upload_error');
        }

        // --- Validação 2: Tamanho ---
        if ($file['size'] > self::MAX_SIZE) {
            $this->redirectBack('error=size');
        }

        // --- Validação 3: Extensão ---
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::ALLOWED_EXT, true)) {
            $this->redirectBack('error=ext');
        }

        // --- Validação 4: MIME type real (leitura do conteúdo) ---
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, self::ALLOWED_MIME, true)) {
            $this->redirectBack('error=mime');
        }

        // --- Gerar nome seguro e único ---
        $filename  = bin2hex(random_bytes(16)) . '_' . $userId . '.' . $ext;
        $uploadDir = self::UPLOAD_DIR;
        $destPath  = $uploadDir . $filename;
        $absPath   = __DIR__ . '/../../' . $destPath;

        // Garantir que o directório existe
        if (!is_dir(dirname($absPath))) {
            mkdir(dirname($absPath), 0755, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $absPath)) {
            $this->redirectBack('error=move');
        }

        // --- Remover foto anterior (se existir) ---
        $this->deleteOldPhoto($userId, $role);

        // --- Actualizar a tabela correcta ---
        $this->saveFotoToDb($userId, $role, $destPath);

        // --- Actualizar sessão para reflectir imediatamente no cabeçalho ---
        $_SESSION['foto_perfil'] = $destPath;

        $this->logActivity('Upload Fotografia de Perfil', ['path' => $destPath]);
        $this->redirectBack('success=foto_updated');
    }

    /**
     * Remove a fotografia de perfil do utilizador autenticado.
     */
    public function removeFoto() {
        $this->verifyCsrfToken();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectBack();
        }

        $userId = (int)$_SESSION['user_id'];
        $role   = $_SESSION['user_role'] ?? '';

        $this->deleteOldPhoto($userId, $role);
        $this->saveFotoToDb($userId, $role, null);

        $_SESSION['foto_perfil'] = null;

        $this->logActivity('Remoção Fotografia de Perfil');
        $this->redirectBack('success=foto_removed');
    }

    // -----------------------------------------------------------------------
    // Métodos privados de suporte
    // -----------------------------------------------------------------------

    /**
     * Obtém o caminho actual da foto de perfil para um utilizador.
     * Consulta a tabela correcta conforme o role.
     *
     * @param int    $userId
     * @param string $role
     * @return string|null
     */
    private function getCurrentFotoPath($userId, $role) {
        $db = Database::getInstance();

        if (in_array($role, ['aluno', 'estudante'], true)) {
            $stmt = $db->prepare("SELECT foto_perfil FROM estudantes WHERE utilizador_id = :uid LIMIT 1");
        } elseif ($role === 'professor') {
            $stmt = $db->prepare("SELECT foto_perfil FROM professores WHERE utilizador_id = :uid LIMIT 1");
        } else {
            // admin, secretaria, outros
            $stmt = $db->prepare("SELECT foto_perfil FROM utilizadores WHERE id = :uid LIMIT 1");
        }

        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['foto_perfil'] : null;
    }

    /**
     * Elimina o ficheiro físico da foto anterior, se existir.
     *
     * @param int    $userId
     * @param string $role
     */
    private function deleteOldPhoto($userId, $role) {
        $oldPath = $this->getCurrentFotoPath($userId, $role);
        if (!empty($oldPath)) {
            $absOld = __DIR__ . '/../../' . $oldPath;
            if (file_exists($absOld) && is_file($absOld)) {
                unlink($absOld);
            }
        }
    }

    /**
     * Actualiza a coluna foto_perfil na tabela correcta para o role dado.
     *
     * @param int         $userId
     * @param string      $role
     * @param string|null $path  Caminho relativo ou NULL para remover
     */
    private function saveFotoToDb($userId, $role, $path) {
        $db = Database::getInstance();

        if (in_array($role, ['aluno', 'estudante'], true)) {
            $stmt = $db->prepare("UPDATE estudantes SET foto_perfil = :foto WHERE utilizador_id = :uid");
        } elseif ($role === 'professor') {
            $stmt = $db->prepare("UPDATE professores SET foto_perfil = :foto WHERE utilizador_id = :uid");
        } else {
            $stmt = $db->prepare("UPDATE utilizadores SET foto_perfil = :foto WHERE id = :uid");
        }

        $stmt->bindValue(':foto', $path);
        $stmt->bindValue(':uid', $userId, PDO::PARAM_INT);
        $stmt->execute();
    }

    /**
     * Redireciona de volta para o referrer com um parâmetro GET opcional.
     *
     * @param string $queryParam
     */
    private function redirectBack($queryParam = '') {
        $referer = $_SERVER['HTTP_REFERER'] ?? (URL_ROOT . '/auth');
        // Limpar parâmetros de foto anteriores do referrer
        $referer = preg_replace('/([?&])(error|success)=[^&]*/', '', $referer);
        $separator = (strpos($referer, '?') !== false) ? '&' : '?';
        $redirect  = $queryParam ? ($referer . $separator . $queryParam) : $referer;
        header('Location: ' . $redirect);
        exit;
    }
}

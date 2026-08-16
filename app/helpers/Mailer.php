<?php
/**
 * Mailer Class — Sistema de Notificações por Email
 * Faculdade Moderna de Direito (FMD)
 *
 * Suporta envio nativo via mail() ou via SMTP usando PHPMailer (se disponível).
 * Para ativar SMTP, configure as constantes em core/config.php:
 *   MAIL_SMTP_HOST, MAIL_SMTP_USER, MAIL_SMTP_PASS, MAIL_SMTP_PORT
 */
class Mailer {

    /**
     * Envia um email formatado com template HTML institucional FMD.
     *
     * @param string      $to      Email do destinatário
     * @param string      $subject Assunto do email
     * @param string      $message Corpo da mensagem (texto ou HTML parcial)
     * @param string|null $from    Remetente (opcional)
     * @return bool
     */
    public static function send($to, $subject, $message, $from = null) {
        $appName = defined('APP_NAME')  ? APP_NAME  : 'Faculdade Moderna de Direito';
        $appShort= defined('APP_SHORT_NAME') ? APP_SHORT_NAME : 'FMD';
        $from    = $from ?? (defined('MAIL_FROM') ? MAIL_FROM : 'no-reply@fmd.edu');
        $year    = date('Y');

        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$appName} <{$from}>\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

        $htmlContent = "
        <!DOCTYPE html>
        <html lang='pt-PT'>
        <head><meta charset='UTF-8'><meta name='viewport' content='width=device-width'></head>
        <body style='margin:0;padding:0;background:#f4f6fa;font-family:Arial,sans-serif;'>
          <table width='100%' cellpadding='0' cellspacing='0' style='background:#f4f6fa;padding:30px 0;'>
            <tr><td align='center'>
              <table width='600' cellpadding='0' cellspacing='0' style='background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);'>
                <!-- Cabeçalho Institucional -->
                <tr>
                  <td style='background:linear-gradient(135deg,#1a2d5a,#2d4a9e);padding:30px 40px;text-align:center;'>
                    <h1 style='color:#ffffff;margin:0;font-size:22px;letter-spacing:1px;'>{$appShort}</h1>
                    <p style='color:#a8b8e0;margin:4px 0 0;font-size:13px;font-weight:600;'>{$appName}</p>
                    <p style='color:#c5cde8;margin:4px 0 0;font-size:11px;'>Sistema de Gestão Académica</p>
                  </td>
                </tr>
                <!-- Corpo -->
                <tr>
                  <td style='padding:40px;color:#333333;'>
                    <h2 style='color:#1a2d5a;margin:0 0 20px;font-size:20px;border-bottom:2px solid #e8ecf8;padding-bottom:12px;'>{$subject}</h2>
                    <div style='line-height:1.7;font-size:15px;color:#444;'>
                      {$message}
                    </div>
                  </td>
                </tr>
                <!-- Rodapé -->
                <tr>
                  <td style='background:#f8f9fd;padding:20px 40px;border-top:1px solid #e8ecf8;text-align:center;'>
                    <p style='margin:0;font-size:12px;color:#888;'>
                      &copy; {$year} {$appName} &mdash; Este é um email automático, não responda.
                    </p>
                  </td>
                </tr>
              </table>
            </td></tr>
          </table>
        </body>
        </html>";

        // Tenta envio real via mail()
        $sent = @mail($to, '=?UTF-8?B?' . base64_encode($subject) . '?=', $htmlContent, $headers);

        // Fallback: regista no log se mail() falhar (ambiente local / sem SMTP)
        if (!$sent) {
            error_log("[FMD Mailer] Email NÃO enviado para {$to} | Assunto: {$subject}");
        } else {
            error_log("[FMD Mailer] Email enviado para {$to} | Assunto: {$subject}");
        }

        return $sent;
    }

    /**
     * Email de Boas-Vindas após aprovação de conta.
     */
    public static function sendWelcome($to, $nome) {
        $prazo   = defined('MATRICULA_PRAZO_HORAS') ? MATRICULA_PRAZO_HORAS : 48;
        $appName = defined('APP_NAME') ? APP_NAME : 'Faculdade Moderna de Direito';
        $urlBase = defined('URL_ROOT') ? 'http://localhost' . URL_ROOT : '#';
        $subject = "Bem-vindo(a) à {$appName} — Conta Aprovada!";
        $message = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>A sua conta no portal da <strong>{$appName}</strong> foi <strong style='color:#2d4a9e;'>aprovada com sucesso</strong>.</p>
            <p>Pode agora aceder ao portal e realizar a sua matrícula dentro do prazo de <strong>{$prazo} horas</strong>.</p>
            <p>Aceda em: <a href='{$urlBase}/auth' style='color:#1a2d5a;font-weight:bold;'>Portal Institucional FMD</a></p>
            <p>Caso tenha dúvidas, contacte a Secretaria da Faculdade.</p>
            <p>Atenciosamente,<br><strong>Secretaria — Faculdade Moderna de Direito</strong></p>
        ";
        return self::send($to, $subject, $message);
    }

    /**
     * Email de confirmação de matrícula aprovada.
     */
    public static function sendMatriculaAprovada($to, $nome, $anoNome = '') {
        $appName = defined('APP_NAME') ? APP_NAME : 'Faculdade Moderna de Direito';
        $urlBase = defined('URL_ROOT') ? 'http://localhost' . URL_ROOT : '#';
        $subject = "Matrícula Aprovada — {$appName}";
        $anoInfo = $anoNome ? " para o <strong>{$anoNome}</strong>" : '';
        $message = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>A sua matrícula{$anoInfo} foi <strong style='color:#2d4a9e;'>aprovada</strong> pela Administração.</p>
            <p>Pode agora aceder ao portal do estudante para acompanhar as suas disciplinas, horários e pagamentos.</p>
            <p>Aceda em: <a href='{$urlBase}/estudante' style='color:#1a2d5a;font-weight:bold;'>Portal do Estudante</a></p>
            <p>Atenciosamente,<br><strong>Secretaria — Faculdade Moderna de Direito</strong></p>
        ";
        return self::send($to, $subject, $message);
    }

    /**
     * Email de notificação de matrícula rejeitada.
     */
    public static function sendMatriculaRejeitada($to, $nome, $motivo = '') {
        $appName = defined('APP_NAME') ? APP_NAME : 'Faculdade Moderna de Direito';
        $subject = "Matrícula Não Aprovada — {$appName}";
        $motivoHtml = $motivo
            ? "<p><strong>Motivo:</strong> <em style='color:#c0392b;'>{$motivo}</em></p>"
            : '';
        $message = "
            <p>Olá, <strong>{$nome}</strong>!</p>
            <p>Infelizmente, a sua matrícula não foi aprovada neste momento.</p>
            {$motivoHtml}
            <p>Por favor, dirija-se à Secretaria da Faculdade ou corrija a documentação e submeta novamente.</p>
            <p>Atenciosamente,<br><strong>Secretaria — Faculdade Moderna de Direito</strong></p>
        ";
        return self::send($to, $subject, $message);
    }
}

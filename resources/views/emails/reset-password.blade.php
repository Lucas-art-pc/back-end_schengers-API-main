<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Redefinição de senha</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

<!-- Texto de pré-visualização (aparece ao lado do assunto na caixa de entrada) -->
<div style="display:none; max-height:0; overflow:hidden; opacity:0; font-size:1px; line-height:1px; color:#f4f6f8;">
    Use o link para redefinir sua senha. Ele expira em {{ $expiresInMinutes ?? 60 }} minutos.
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px 10px;">
    <tr>
        <td align="center">

            <!-- Container -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                   style="max-width:480px; background-color:#ffffff; border-radius:8px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td align="center" style="background-color:#1e40af; padding:28px 20px;">
                        <p style="margin:0 0 6px 0; font-size:13px; font-weight:bold; letter-spacing:2px; color:#fcac21;">
                            SCHENGERS
                        </p>
                        <p style="margin:0; font-size:20px; font-weight:bold; color:#ffffff;">
                            Redefinição de senha
                        </p>
                    </td>
                </tr>

                <!-- Conteúdo -->
                <tr>
                    <td style="padding:30px 30px 10px 30px; color:#333333;">
                        <p style="font-size:15px; margin:0 0 24px 0; line-height:1.6;">
                            Recebemos uma solicitação para redefinir a senha da sua conta.
                            Clique no botão abaixo para continuar.
                        </p>

                        <!-- Botão -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding-bottom:24px;">
                                    <a href="{{ $resetLink }}"
                                       target="_blank"
                                       style="background-color:#1e40af; color:#ffffff; text-decoration:none;
                                              padding:14px 32px; border-radius:6px; font-size:15px;
                                              font-weight:bold; display:inline-block;">
                                        Redefinir minha senha
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Aviso de expiração -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="background-color:#f1f5f9; border-radius:6px; padding:12px 16px;
                                           font-size:13px; line-height:1.5; color:#64748b;">
                                    Este link expira em
                                    <strong style="color:#1a1a1a;">{{ $expiresInMinutes ?? 60 }} minutos</strong>.
                                    Depois disso, será necessário solicitar um novo.
                                </td>
                            </tr>
                        </table>

                        <p style="margin:20px 0 0 0; font-size:13px; color:#64748b; line-height:1.6;">
                            Se você não solicitou a redefinição de senha, ignore este e-mail.
                            Sua senha permanece a mesma.
                        </p>
                    </td>
                </tr>

                <!-- Link alternativo -->
                <tr>
                    <td align="center" style="padding:20px 30px 24px 30px;">
                        <p style="margin:0; font-size:12px; line-height:1.6; color:#64748b;">
                            Se o botão não funcionar, copie e cole este link no navegador:
                        </p>
                        <p style="margin:6px 0 0 0; font-size:12px; line-height:1.6;">
                            <a href="{{ $resetLink }}" style="color:#1e40af; word-break:break-all;">{{ $resetLink }}</a>
                        </p>
                    </td>
                </tr>

                <!-- Rodapé -->
                <tr>
                    <td align="center"
                        style="background-color:#f1f5f9; padding:15px 20px;
                               font-size:12px; line-height:1.6; color:#64748b;">
                        &copy; {{ date('Y') }} Plataforma Schengers. Todos os direitos reservados.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
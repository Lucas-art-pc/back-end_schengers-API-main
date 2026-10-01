<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <title>Cadastro aprovado</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

@php
    $loginUrl = rtrim(config('app.frontend_url', 'https://plataform.schengers.com.br'), '/') . '/auth/login-teacherUser';
@endphp

<!-- Texto de pré-visualização (aparece ao lado do assunto na caixa de entrada) -->
<div style="display:none; max-height:0; overflow:hidden; opacity:0; font-size:1px; line-height:1px; color:#f4f6f8;">
    Seu cadastro como professor foi aprovado. Acesse a plataforma Schengers.
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px 10px;">
    <tr>
        <td align="center">

            <!-- Container -->
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                   style="max-width:600px; background-color:#ffffff; border-radius:8px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td align="center" style="background-color:#1e40af; padding:20px;">
                        <p style="margin:0; font-size:24px; font-weight:bold; letter-spacing:1px; color:#ffffff; font-family:Arial, Helvetica, sans-serif;">
                            SCHENGERS
                        </p>
                    </td>
                </tr>

                <!-- Faixa de destaque -->
                <tr>
                    <td style="background-color:#fcac21; height:4px; line-height:4px; font-size:0;">&nbsp;</td>
                </tr>

                <!-- Conteúdo -->
                <tr>
                    <td style="padding:30px; color:#333333;">
                        <p style="font-size:16px; margin:0 0 16px 0;">
                            Olá, <strong>{{ $teacher->name }}</strong>!
                        </p>

                        <p style="font-size:15px; margin:0 0 16px 0; line-height:1.6;">
                            Temos o prazer de informar que seu cadastro como professor foi
                            <strong style="color:#16a34a;">aprovado</strong>.
                        </p>

                        <p style="font-size:15px; margin:0 0 24px 0; line-height:1.6;">
                            A partir de agora, você já pode acessar a plataforma e utilizar todos os recursos disponíveis,
                            como criar cursos e acompanhar seus alunos.
                        </p>

                        <!-- Botão -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding-bottom:24px;">
                                    <a href="{{ $loginUrl }}"
                                       target="_blank"
                                       style="background-color:#1e40af; color:#ffffff; text-decoration:none;
                                              padding:14px 32px; border-radius:6px; font-size:15px;
                                              font-weight:bold; display:inline-block;">
                                        Acessar a plataforma
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <!-- Link alternativo, caso o botão não funcione -->
                        <p style="font-size:12px; color:#64748b; line-height:1.6; margin:0 0 24px 0; text-align:center;">
                            Se o botão não funcionar, copie e cole este endereço no navegador:<br>
                            <a href="{{ $loginUrl }}" style="color:#1e40af; word-break:break-all;">{{ $loginUrl }}</a>
                        </p>

                        <p style="font-size:14px; color:#555555; line-height:1.6; margin:0;">
                            Atenciosamente,<br>
                            <strong>Equipe da Plataforma Schengers</strong>
                        </p>
                    </td>
                </tr>

                <!-- Rodapé -->
                <tr>
                    <td align="center"
                        style="background-color:#f1f5f9; padding:15px 20px;
                               font-size:12px; line-height:1.6; color:#64748b;">
                        Você recebeu este e-mail porque foi aprovado como professor na Plataforma Schengers.<br>
                        &copy; {{ date('Y') }} Plataforma Schengers. Todos os direitos reservados.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
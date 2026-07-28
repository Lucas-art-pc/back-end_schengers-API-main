<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro aprovado</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:20px;">
    <tr>
        <td align="center">

            <!-- Container -->
            <table width="600" cellpadding="0" cellspacing="0"
                   style="background-color:#ffffff; border-radius:8px; overflow:hidden;">

                <!-- Header -->
                <tr>
                    <td align="center" style="background-color:#1e40af; padding:20px;">
                        <p style="margin:0; font-size:24px; font-weight:bold; color:#ffffff; font-family:Arial, Helvetica, sans-serif;">
                            SCHENGERS
                        </p>
                    </td>
                </tr>


                <!-- Content -->
                <tr>
                    <td style="padding:30px; color:#333333;">
                        <p style="font-size:16px; margin:0 0 16px 0;">
                            Olá <strong>{{ $teacher->name }}</strong>,
                        </p>

                        <p style="font-size:15px; margin:0 0 16px 0; line-height:1.6;">
                            Temos o prazer de informar que seu cadastro como professor foi
                            <strong style="color:#16a34a;">aprovado</strong>.
                        </p>

                        <p style="font-size:15px; margin:0 0 24px 0; line-height:1.6;">
                            A partir de agora, você já pode acessar a plataforma e utilizar todos os recursos disponíveis.
                        </p>

                        <!-- Button -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding-bottom:30px;">
                                    <a href="{{ url('https://schegers-plataform.vercel.app/') }}"
                                       style="background-color:#1e40af; color:#ffffff; text-decoration:none;
                                              padding:12px 28px; border-radius:6px; font-size:15px;
                                              display:inline-block;">
                                        Acessar a plataforma
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="font-size:14px; color:#555555; line-height:1.6; margin:0;">
                            Atenciosamente,<br>
                            <strong>Equipe da Plataforma Schengers</strong>
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td align="center"
                        style="background-color:#f1f5f9; padding:15px;
                               font-size:12px; color:#64748b;">
                        © {{ date('Y') }} Plataforma Schengers. Todos os direitos reservados.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>

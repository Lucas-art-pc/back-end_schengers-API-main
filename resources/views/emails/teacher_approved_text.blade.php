@php
    $loginUrl = rtrim(config('app.frontend_url', 'https://plataform.schengers.com.br'), '/') . '/auth/login-teacherUser';
@endphp
Olá, {{ $teacher->name }}!

Temos o prazer de informar que seu cadastro como professor foi aprovado.

A partir de agora, você já pode acessar a plataforma e utilizar todos os recursos disponíveis.

Acesse a plataforma:
{{ $loginUrl }}

Atenciosamente,
Equipe da Plataforma Schengers

© {{ date('Y') }} Plataforma Schengers. Todos os direitos reservados.
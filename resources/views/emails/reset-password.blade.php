<div style="background: #f4f4f8; padding: 2rem; display: flex; justify-content: center; font-family: Arial, sans-serif;">
    <div style="max-width: 480px; width: 100%; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">

        <!-- Header -->
        <div style="background: #26215C; padding: 2rem; text-align: center;">
            <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
            </div>
            <p style="margin: 0; color: white; font-size: 18px; font-weight: 500;">Redefinição de senha</p>
        </div>

        <!-- Body -->
        <div style="padding: 2rem 2rem 1.5rem;">
            <p style="margin: 0 0 1rem; font-size: 15px; color: #1a1a1a; line-height: 1.6;">
                Recebemos uma solicitação para redefinir a senha da sua conta. Clique no botão abaixo para continuar.
            </p>

            <div style="text-align: center; margin: 1.75rem 0;">
                <a href="{{ $resetLink }}" style="display: inline-block; background: #534AB7; color: white; font-size: 15px; font-weight: 500; text-decoration: none; padding: 0.75rem 2rem; border-radius: 8px;">
                    Redefinir minha senha
                </a>
            </div>

            <div style="background: #f4f4f8; border-radius: 8px; padding: 0.875rem 1rem; display: flex; align-items: center; gap: 10px; margin-top: 1.5rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
                <p style="margin: 0; font-size: 13px; color: #6b7280; line-height: 1.5;">
                    Este link expira em <strong style="font-weight: 500; color: #1a1a1a;">60 minutos</strong>. Após isso, será necessário solicitar um novo.
                </p>
            </div>

            <p style="margin: 1.5rem 0 0; font-size: 13px; color: #6b7280; line-height: 1.6;">
                Se você não solicitou a redefinição de senha, ignore este e-mail. Sua senha permanece a mesma.
            </p>
        </div>

        <!-- Footer -->
        <div style="border-top: 1px solid #e5e7eb; padding: 1rem 2rem; text-align: center;">
            <p style="margin: 0; font-size: 12px; color: #6b7280;">Se o botão não funcionar, copie e cole este link no navegador:</p>
            <p style="margin: 0.5rem 0 0; font-size: 12px; color: #534AB7; word-break: break-all;">{{ $resetLink }}</p>
        </div>

    </div>
</div>

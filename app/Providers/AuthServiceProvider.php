<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Verifique seu endereço de e-mail')
                ->line('Clique no botão abaixo para verificar seu endereço de e-mail.')
                ->action('Verifique seu endereço de e-mail', $url)
                ->line('Se você não criou uma conta, nenhuma ação adicional é necessária.');
        });

        ResetPassword::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Notificação de resete de senha!')
                ->line('Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha da sua conta.')
                ->action('Resetar senha', $url)
                ->line('Este link de redefinição de senha expirará em :count minutos.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')])
                ->line('Se você não solicitou uma redefinição de senha, nenhuma ação adicional será necessária.');
        });
    }
}

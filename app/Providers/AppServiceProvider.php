<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TwilioClient::class, function ($app) {
            return new TwilioClient(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        });

        $this->app->alias(TwilioClient::class, 'Twilio');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            $url = url('/student/reset-password/' . $token);
            return (new MailMessage)
                ->greeting('Bonjour!')
                ->subject('Réinitialisation de mot de passe')
                ->line('Vous recevez cet e-mail parce que nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.')
                ->action('Réinitialiser le mot de passe', $url)
                ->line('Si vous n\'avez pas demandé de réinitialisation de mot de passe, aucune action supplémentaire n\'est requise.');
        });
    }
}

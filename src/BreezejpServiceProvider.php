<?php

namespace Askdkc\Breezejp;

use Askdkc\Breezejp\Commands\BreezejpCommand;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BreezejpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('breezejp')
            ->hasCommand(BreezejpCommand::class);
    }

    public function boot(): PackageServiceProvider
    {
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new MailMessage)
                ->subject(__('Reset Password Notification'))
                ->line(__('You are receiving this email because we received a password reset request for your account.'))
                ->action(__('Reset Password'), route('password.reset', $token))
                ->line(__('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(__('If you did not request a password reset, no further action is required.'))
                ->line(__('Regards'))
                ->salutation(\config('app.name'));
        });

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(__('Verify Email Address'))
                ->line(__('Please click the button below to verify your email address.'))
                ->action(__('Verify Email Address'), $url)
                ->line(__('If you did not create an account, no further action is required.'))
                ->line(__('Regards'))
                ->salutation(__(\config('app.name')));
        });

        return parent::boot();
    }
}

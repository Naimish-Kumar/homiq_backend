<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        // Dynamically load and configure SMTP settings from database configurations
        try {
            if (\Schema::hasTable('configurations')) {
                $configs = \DB::table('configurations')->where('group', 'smtp')->get();
                $mailConfig = [];
                foreach ($configs as $config) {
                    $mailConfig[$config->key] = $config->value;
                }

                if (!empty($mailConfig['mail_host'])) {
                    config([
                        'mail.default' => 'smtp',
                        'mail.mailers.smtp.host' => $mailConfig['mail_host'],
                        'mail.mailers.smtp.port' => intval($mailConfig['mail_port'] ?? 2525),
                        'mail.mailers.smtp.encryption' => $mailConfig['mail_encryption'] ?? 'tls',
                        'mail.mailers.smtp.username' => $mailConfig['mail_username'] ?? null,
                        'mail.mailers.smtp.password' => $mailConfig['mail_password'] ?? null,
                        'mail.from.address' => $mailConfig['mail_from_address'] ?? 'hello@homiq.com',
                        'mail.from.name' => $mailConfig['mail_from_name'] ?? 'HomiQ System',
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Silence exceptions during database setup or migrations
        }

        view()->composer('*', function ($view) {
            if (request()->is('admin*') || request()->is('livewire/update') || request()->is('old-admin*')) {
                return;
            }
            if (auth()->check()) {
                $notifications = \App\Models\Notification::where('user_id', auth()->id())
                    ->latest()
                    ->take(10)
                    ->get();
                $unreadNotificationsCount = \App\Models\Notification::where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();
                
                $unreadMessagesCount = \App\Models\Message::whereHas('chat', function ($query) {
                    $query->where('user_one_id', auth()->id())
                          ->orWhere('user_two_id', auth()->id());
                })
                ->where('sender_id', '!=', auth()->id())
                ->where('is_read', false)
                ->count();

                $view->with(compact('notifications', 'unreadNotificationsCount', 'unreadMessagesCount'));
            }
        });
    }
}

<?php

namespace App\Providers;

use App\Models\SiteSettings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Share site settings with every view
        View::composer('*', function ($view) {
            try {
                $siteSettings = SiteSettings::get();
            } catch (\Throwable $e) {
                // Table may not exist yet during migrations
                $siteSettings = new SiteSettings([
                    'site_name'   => 'WEIN',
                    'admin_name'  => null,
                    'admin_phone' => null,
                ]);
            }
            $view->with('siteSettings', $siteSettings);
        });
    }
}

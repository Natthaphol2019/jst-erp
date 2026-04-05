<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Models\RolePermission;

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
        Paginator::useBootstrap();
        Paginator::defaultView('vendor.pagination.bootstrap-5');

        // ==========================================
        // Blade Directives for Permissions
        // ==========================================

        // @canpermission('hr.employees', 'view')
        Blade::directive('canpermission', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasPermission({$expression}))): ?>";
        });

        Blade::directive('endcanpermission', function () {
            return '<?php endif; ?>';
        });

        // @canview('hr.employees')
        Blade::directive('canview', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasPermission({$expression}, 'view'))): ?>";
        });

        Blade::directive('endcanview', function () {
            return '<?php endif; ?>';
        });

        // @cancreate('hr.employees')
        Blade::directive('cancreate', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasPermission({$expression}, 'create'))): ?>";
        });

        Blade::directive('endcancreate', function () {
            return '<?php endif; ?>';
        });

        // @canedit('hr.employees')
        Blade::directive('canedit', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasPermission({$expression}, 'edit'))): ?>";
        });

        Blade::directive('endcanedit', function () {
            return '<?php endif; ?>';
        });

        // @candelete('hr.employees')
        Blade::directive('candelete', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasPermission({$expression}, 'delete'))): ?>";
        });

        Blade::directive('endcandelete', function () {
            return '<?php endif; ?>';
        });

        // @canexport('hr.employees')
        Blade::directive('canexport', function ($expression) {
            return "<?php if(auth()->check() && (auth()->user()->isAdmin() || auth()->user()->hasPermission({$expression}, 'export'))): ?>";
        });

        Blade::directive('endcanexport', function () {
            return '<?php endif; ?>';
        });

        // Share visible modules with all views
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('visibleModules', auth()->user()->getVisibleModules());
            }
        });
    }
}

<?php

namespace Modules\Employee\Http\Middleware;

use Closure;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         *
         * Module Menu for Admin Backend
         *
         * *********************************************************************
         */
        \Menu::make('admin_sidebar', function ($menu) {

            // Employees
            $menu->add('<i class="fas fa-user-tie c-sidebar-nav-icon"></i> Employees', [
                'route' => 'backend.employees.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 88,
                'activematches' => ['admin/employees*'],
                'permission'    => ['view_employees'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

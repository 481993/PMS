<?php

namespace Modules\Employeerole\Http\Middleware;

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

            // Employeeroles
            $menu->add('<i class="fas fa-user-alt c-sidebar-nav-icon"></i> Employee Roles', [
                'route' => 'backend.employeeroles.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 89,
                'activematches' => ['admin/employeeroles*'],
                'permission'    => ['view_employeeroles'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

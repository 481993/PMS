<?php

namespace Modules\Department\Http\Middleware;

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

            // Departments
            $menu->add('<i class="fas fa-landmark c-sidebar-nav-icon"></i> Departments', [
                'route' => 'backend.departments.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 80,
                'activematches' => ['admin/departments*'],
                'permission'    => ['view_departments'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

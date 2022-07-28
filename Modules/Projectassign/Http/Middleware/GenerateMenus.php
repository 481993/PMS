<?php

namespace Modules\Projectassign\Http\Middleware;

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

            // Projectassigns
            $menu->add('<i class="fas fa-user-clock c-sidebar-nav-icon"></i> Project Assign Employee', [
                'route' => 'backend.projectassigns.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 82,
                'activematches' => ['admin/projectassigns*'],
                'permission'    => ['view_projectassigns'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

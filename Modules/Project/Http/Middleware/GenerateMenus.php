<?php

namespace Modules\Project\Http\Middleware;

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

            // Projects
            $menu->add('<i class="fas fa-paste c-sidebar-nav-icon"></i> Projects', [
                'route' => 'backend.projects.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 81,
                'activematches' => ['admin/projects*'],
                'permission'    => ['view_projects'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

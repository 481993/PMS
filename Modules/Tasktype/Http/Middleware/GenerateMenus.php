<?php

namespace Modules\Tasktype\Http\Middleware;

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

            // Tasktypes
            $menu->add('<i class="fas fa-sitemap c-sidebar-nav-icon"></i> Task Types', [
                'route' => 'backend.tasktypes.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 85,
                'activematches' => ['admin/tasktypes*'],
                'permission'    => ['view_tasktypes'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

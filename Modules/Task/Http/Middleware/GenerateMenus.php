<?php

namespace Modules\Task\Http\Middleware;

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

            // Tasks
            $menu->add('<i class="fas fa-list-ul c-sidebar-nav-icon"></i> Tasks', [
                'route' => 'backend.tasks.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 84,
                'activematches' => ['admin/tasks*'],
                'permission'    => ['view_tasks'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

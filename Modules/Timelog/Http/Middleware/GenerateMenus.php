<?php

namespace Modules\Timelog\Http\Middleware;

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

            // Timelogs
            $menu->add('<i class="fas fa-business-time c-sidebar-nav-icon"></i> Timelogs', [
                'route' => 'backend.timelogs.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 84,
                'activematches' => ['admin/timelogs*'],
                'permission'    => ['view_timelogs'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

<?php

namespace Modules\Timelogright\Http\Middleware;

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

            // Timelogrights
            $menu->add('<i class="fas fa-check c-sidebar-nav-icon"></i> Timelog Rights', [
                'route' => 'backend.timelogrights.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 87,
                'activematches' => ['admin/timelogrights*'],
                'permission'    => ['view_timelogrights'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

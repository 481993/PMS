<?php

namespace Modules\Milestone\Http\Middleware;

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

            // Milestones
            $menu->add('<i class="fas fa-medal c-sidebar-nav-icon"></i> Milestones', [
                'route' => 'backend.milestones.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 83,
                'activematches' => ['admin/milestones*'],
                'permission'    => ['view_milestones'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

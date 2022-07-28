<?php

namespace Modules\Resource\Http\Middleware;

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

            // Resources
            $menu->add('<i class="fas fa-sitemap c-sidebar-nav-icon"></i> Resource', [
                'route' => 'backend.resources.index',
                'class' => 'c-sidebar-nav-item',
            ])
            ->data([
                'order'         => 87,
                'activematches' => ['admin/resources*'],
                'permission'    => ['view_resources'],
            ])
            ->link->attr([
                'class' => 'c-sidebar-nav-link',
            ]);
        })->sortBy('order');

        return $next($request);
    }
}

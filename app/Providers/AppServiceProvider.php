<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layout.main', function($view)
        {
            $menus = Menu::with(['childmenus' => function($sql){
                    $sql->whereHas('roles', function($sql){
                        $sql->where('grpid', session('TMP_ROLE'));
                    });
                    $sql->orderBy('seq', 'asc');
                    $sql->with(['childmenus' => function($sql){
                        $sql->whereHas('roles', function($sql){
                            $sql->where('grpid', session('TMP_ROLE'));
                        });
                        $sql->orderBy('seq', 'asc');
                    }]);
                }])
                ->whereHas('roles', function($sql){
                    $sql->where('grpid', session('TMP_ROLE'));
                })
                ->whereIn('level', [0, 1])
                ->orderBy('seq', 'asc')
                ->get();

            $generatedMenu = '';
            foreach ($menus as $i => $menu) {
                if($menu->level == 0){
                    $generatedMenu .= $this->menu0($menu);
                }else{
                    $generatedMenu .= $this->generate($menu);
                }
            }
            $view->with('menus', $generatedMenu);
        });
    }

    private function menu0($menu)
    {
        return '<div data-kt-menu-trigger="{default: \'click\', lg: \'hover\'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
            <span class="menu-link py-3">
                <span class="menu-title">' . $menu->name . '</span>
                <span class="menu-arrow d-lg-none"></span>
            </span>
            <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                <div class="hover-scroll-overlay-y mh-300px">
                    <div class="menu-item">
                        <a class="menu-link py-3" href="' . route($menu->route_name) . '">
                            <span class="menu-icon">
                                <i class="bi bi-archive fs-3"></i>
                            </span>
                            <span class="menu-title">Example</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>';
    }

    private function generate($menu)
    {
        if($menu->level == 1){
            $child = '';
            foreach ($menu->childmenus as $ch) {
                $child .= $this->generate($ch);
            }
            $parent = '<div data-kt-menu-trigger="{default: \'click\', lg: \'hover\'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">' . $menu->name . '</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                    ' . $child . '
                </div>
            </div>';
        }elseif (in_array($menu->level, [2, 4])) {
            $parent = '<div class="menu-item">
                <a class="menu-link py-3" href="' . route($menu->route_name) . '">
                    <span class="menu-icon">
                        <i class="bi bi-card-list fs-3"></i>
                    </span>
                    <span class="menu-title">' . $menu->name . '</span>
                </a>
            </div>';
        }elseif ($menu->level == 3) {
            $child = '';
            foreach ($menu->childmenus as $ch) {
                $child .= $this->generate($ch);
            }
            $parent = '<div data-kt-menu-trigger="{default:\'click\', lg: \'hover\'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
                <span class="menu-link py-3">
                    <span class="menu-icon">
                        <i class="bi bi-archive fs-3"></i>
                    </span>
                    <span class="menu-title">' . $menu->name . '</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                    ' . $child . '
                </div>
            </div>';
        }
        return $parent;
    }
}

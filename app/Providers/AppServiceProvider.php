<?php

namespace App\Providers;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\LevelRepository;
use App\Repositories\ContestRepository;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $userRepo = resolve(UserRepository::class);
        view()->composer('*', function ($view) use ($userRepo) {
            if (request()->segment(1) != 'admin') {
                $locale = app()->getLocale();
                $prefix = $locale != 'en' ? '_' . $locale : '';
                $userRepo->setScopesAttr(['RoleTeacher' => []]);
                $view->with([
                    'countStudents' => resolve(StudentRepository::class)->count(),
                    'countTeachers' => $userRepo->count(),
                    'countContests' => resolve(ContestRepository::class)->count(),
                    'prefix' => $prefix,
                    'contestLevels' => resolve(LevelRepository::class)->getLevelHasContests(),
                    'frontendRoles' => config('backpack.permissionmanager.models.role')::whereIn('id', (new User())->frontendRoleIds())->pluck('name', 'id')->toArray(),
                ]);
            }
        });
        $this->overrideConfigValues();
    }

    protected function overrideConfigValues()
    {
        $config = [];
        if (config('settings.skin')) {
            $skinClasses = explode(',', config('settings.skin'));
            $config['backpack.base.header_class'] = $skinClasses[0];
            $config['backpack.base.body_class'] = $skinClasses[1];
            $config['backpack.base.sidebar_class'] = $skinClasses[2];
            $config['backpack.base.footer_class'] = $skinClasses[3];
        }
        if (config('settings.show_powered_by')) {
            $config['backpack.base.show_powered_by'] = config('settings.show_powered_by') == '1';
        }
        if (config('settings.project_name')) {
            $config['backpack.base.project_name'] = config('settings.project_name');
        }
        if (config('settings.project_logo')) {
            $config['backpack.base.project_logo'] = config('settings.project_logo');
        }
        if (config('settings.browser_tab_logo')) {
            $config['backpack.base.browser_tab_logo'] = config('settings.browser_tab_logo');
        }
        config($config);
    }
}

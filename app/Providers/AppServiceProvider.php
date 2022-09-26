<?php

namespace App\Providers;

use App\Observers\DocumentObserver;
use App\Models\{Document, MenuItem, SystemSetting, User};
use App\Observers\SystemSettingObserver;
use App\Observers\UserObserver;
use App\Repositories\AccountRepository;
use App\Repositories\AdministrationRepository;
use App\Repositories\DictionaryRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\LogRepository;
use App\Repositories\PasswordRepository;
use App\Repositories\SystemSettingRepository;
use App\RepositoryInterfaces\AccountRepositoryInterface;
use App\RepositoryInterfaces\AdministrationRepositoryInterface;
use App\RepositoryInterfaces\DictionaryRepositoryInterface;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use App\RepositoryInterfaces\LogRepositoryInterface;
use App\RepositoryInterfaces\PasswordRepositoryInterface;
use App\RepositoryInterfaces\SystemSettingRepositoryInterface;
use Illuminate\Support\Facades\View;
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
        $this->app->bind(PasswordRepositoryInterface::class, PasswordRepository::class);
        $this->app->bind(AccountRepositoryInterface::class, AccountRepository::class);
        $this->app->bind(SystemSettingRepositoryInterface::class, SystemSettingRepository::class);
        $this->app->bind(LogRepositoryInterface::class, LogRepository::class);
        $this->app->bind(AdministrationRepositoryInterface::class, AdministrationRepository::class);
        $this->app->bind(DictionaryRepositoryInterface::class, DictionaryRepository::class);
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        SystemSetting::observe(SystemSettingObserver::class);
        User::observe(UserObserver::class);
        Document::observe(DocumentObserver::class);

        $systemService = SystemSetting::find(1);

        // Get menu available for user
        view()->composer('layouts.menu', function () {
            $menuItems = MenuItem::whereIn('id', function ($query) {
                $query->select('id')->from('menu_item_user')->where('user_role', auth()->user()->role);
            })->get();
            View::share('menuItems', $menuItems);
        });

        View::share('companyLogo', $systemService->logo);
        View::share('companyColor', $systemService->color);
    }
}

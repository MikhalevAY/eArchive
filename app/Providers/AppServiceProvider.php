<?php

namespace App\Providers;

use App\Observers\AccessRequestObserver;
use App\Observers\DocumentObserver;
use App\Repositories\AccessRequestRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\DocumentAccessRepository;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use App\RepositoryInterfaces\AttachmentRepositoryInterface;
use App\Models\{AccessRequest, Document, MenuItem, SystemSetting, User};
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
use App\RepositoryInterfaces\DocumentAccessRepositoryInterface;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use App\RepositoryInterfaces\LogRepositoryInterface;
use App\RepositoryInterfaces\PasswordRepositoryInterface;
use App\RepositoryInterfaces\SystemSettingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
        $this->app->bind(AttachmentRepositoryInterface::class, AttachmentRepository::class);
        $this->app->bind(AccessRequestRepositoryInterface::class, AccessRequestRepository::class);
        $this->app->bind(DocumentAccessRepositoryInterface::class, DocumentAccessRepository::class);
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
        AccessRequest::observe(AccessRequestObserver::class);

        // Get menu available for user
        view()->composer('layouts.menu', function () {
            $menuItems = MenuItem::whereIn('id', function ($query) {
                $query->select('menu_item_id')->from('menu_item_user')->where('user_role', auth()->user()->role);
            })->get();
            View::share('menuItems', $menuItems);
        });

        if (Schema::hasTable('system_settings')) {
            $systemService = SystemSetting::find(1);
            if ($systemService) {
                View::share('companyLogo', $systemService->logo);
                View::share('companyColor', $systemService->color);
            }
        }
    }
}

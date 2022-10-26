<?php

namespace App\Providers;

use App\Models\{AccessRequest, Dictionary, Document, SystemSetting, User};
use App\Observers\{AccessRequestObserver, DictionaryObserver, DocumentObserver, SystemSettingObserver, UserObserver};
use App\Repositories\AccessRequestRepository;
use App\Repositories\AccountRepository;
use App\Repositories\AdministrationRepository;
use App\Repositories\AttachmentRepository;
use App\Repositories\DictionaryRepository;
use App\Repositories\DocumentAccessRepository;
use App\Repositories\DocumentRepository;
use App\Repositories\LogRepository;
use App\Repositories\MenuItemRepository;
use App\Repositories\PasswordRepository;
use App\Repositories\SystemSettingRepository;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use App\RepositoryInterfaces\AccountRepositoryInterface;
use App\RepositoryInterfaces\AdministrationRepositoryInterface;
use App\RepositoryInterfaces\AttachmentRepositoryInterface;
use App\RepositoryInterfaces\DictionaryRepositoryInterface;
use App\RepositoryInterfaces\DocumentAccessRepositoryInterface;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use App\RepositoryInterfaces\LogRepositoryInterface;
use App\RepositoryInterfaces\MenuItemRepositoryInterface;
use App\RepositoryInterfaces\PasswordRepositoryInterface;
use App\RepositoryInterfaces\SystemSettingRepositoryInterface;
use Illuminate\Support\Facades\{Schema, View};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
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
        $this->app->bind(MenuItemRepositoryInterface::class, MenuItemRepository::class);
    }

    public function boot(): void
    {
        SystemSetting::observe(SystemSettingObserver::class);
        User::observe(UserObserver::class);
        Document::observe(DocumentObserver::class);
        AccessRequest::observe(AccessRequestObserver::class);
        Dictionary::observe(DictionaryObserver::class);

        view()->composer('layouts.menu', function () {
            $menuItems = (new MenuItemRepository())->availableForUser();
            View::share('menuItems', $menuItems);
        });

        $companyLogo = null;
        $companyColor = '#999';

        if (Schema::hasTable('system_settings')) {
            $systemSetting = SystemSetting::query()->find(1);
            if ($systemSetting) {
                $companyColor = $systemSetting->color;
                $companyLogo = $systemSetting->logo;
            }
        }

        View::share('companyLogo', $companyLogo);
        View::share('companyColor', $companyColor);
    }
}

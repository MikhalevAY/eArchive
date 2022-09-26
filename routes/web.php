<?php

use Illuminate\Support\Facades\{Artisan, Route};
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\ReadingRoomController;

Route::get('/', [AuthController::class, 'index'])->name('authPage');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/remind-password', [PasswordController::class, 'remind'])->name('remindPassword');
Route::post('/restore-password', [PasswordController::class, 'restore'])->name('restorePassword');
Route::post('/update-password', [PasswordController::class, 'update'])->name('updatePassword');
Route::get('/new-password/{md5Email}', [PasswordController::class, 'new'])->name('newPassword');

Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['checkUserPermission']], function () {
        Route::get('/archive-search', [ArchiveController::class, 'index'])->name('archiveSearch');
        Route::get('/system-settings', [SystemSettingController::class, 'index'])->name('systemSetting');
        Route::get('/registration-of-documents', [DocumentController::class, 'index'])->name('registrationOfDocuments');
        Route::get('/reading-room', [ReadingRoomController::class, 'index'])->name('readingRoom');
        Route::get('/administration', [AdministrationController::class, 'index'])->name('administration');
        Route::get('/system-logs', [LogController::class, 'index'])->name('logs');
        Route::get('/requests', [SystemSettingController::class, 'index'])->name('requests');

        Route::post('/system-settings/update', [SystemSettingController::class, 'update'])->name('updateSystemSetting');

        Route::controller(AdministrationController::class)->prefix('administration')->group(function () {
            Route::post('/update/{user}', 'update')->name('adm.updateUser');
            Route::post('/store', 'store')->name('adm.storeUser');
            Route::post('/reset-password/{user}', 'resetPassword')->name('adm.resetPassword');
            Route::delete('/delete/{user}', 'delete')->name('adm.deleteUser');
            Route::delete('/delete-selected', 'deleteSelected')->name('adm.deleteSelectedUsers');
        });

        Route::controller(DocumentController::class)->prefix('registration-of-documents')->group(function () {
            Route::get('add', 'add')->name('document.add');
            Route::get('list', 'list')->name('document.list');
            Route::post('store', 'store')->name('document.store');
        });
    });

    Route::controller(ModalController::class)->group(function () {
        Route::post('/modal/edit-personal-data', 'editPersonalData')->name('editPersonalData');
        Route::post('/modal/edit-personal-password', 'editPersonalPassword')->name('editPersonalPassword');
        Route::post('/modal/edit-personal-photo', 'editPersonalPhoto')->name('editPersonalPhoto');
        Route::post('/modal/edit-user/{user}', 'editUser')->name('editUser');
        Route::post('/modal/add-user', 'addUser')->name('addUser');
        Route::post('/modal/reset-user-password/{user}', 'resetPassword')->name('resetPassword');
        Route::post('/modal/delete-user/{user}', 'deleteUser')->name('deleteUser');
        Route::post('/modal/delete-selected-users', 'deleteSelectedUsers')->name('deleteSelectedUsers');
        Route::post('/modal/search-documents', 'searchDocuments')->name('searchAvailableDocuments');
    });

    Route::controller(AccountController::class)->prefix('account')->group(function () {
        Route::post('/update', 'update')->name('updatePersonalData');
        Route::post('/update-password', 'updatePassword')->name('updatePersonalPassword');
        Route::post('/update-photo', 'updatePhoto')->name('updatePersonalPhoto');
    });
});

Route::get('/artisan/{command}', function ($c) {
    Artisan::call($c, []);
});

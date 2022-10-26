<?php

use App\Http\Controllers\AccessRequestController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdministrationController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ReadingRoomController;
use App\Http\Controllers\SystemSettingController;
use Illuminate\Support\Facades\{Artisan, Route};

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
        Route::get('/archive-search/results', [ArchiveController::class, 'results'])->name('archiveSearchList');
        Route::get('/system-settings', [SystemSettingController::class, 'index'])->name('systemSetting');
        Route::get('/registration-of-documents', [DocumentController::class, 'index'])->name('registrationOfDocuments');
        Route::get('/reading-room', [ReadingRoomController::class, 'index'])->name('readingRoom');
        Route::get('/administration', [AdministrationController::class, 'index'])->name('administration');
        Route::get('/system-logs', [LogController::class, 'index'])->name('logs');
        Route::get('/access-requests', [AccessRequestController::class, 'index'])->name('accessRequests');
        Route::get('/dictionaries', [DictionaryController::class, 'index'])->name('dictionaries');

        Route::post('/system-settings/update', [SystemSettingController::class, 'update'])->name('updateSystemSetting');

        Route::controller(AdministrationController::class)->prefix('administration')->group(function () {
            Route::post('/update/{user}', 'update')->name('adm.update');
            Route::post('/set-state/{user}', 'setState')->name('adm.setState');
            Route::post('/store', 'store')->name('adm.store');
            Route::post('/reset-password/{user}', 'resetPassword')->name('adm.resetPassword');
            Route::delete('/delete/{user}', 'delete')->name('adm.delete');
            Route::delete('/delete-selected', 'deleteSelected')->name('adm.deleteSelected');
        });

        Route::controller(DictionaryController::class)->prefix('dictionaries')->group(function () {
            Route::post('/store', 'store')->name('dictionary.store');
            Route::delete('/delete/{dictionary}', 'delete')->name('dictionary.delete');
        });

        Route::controller(DocumentController::class)->prefix('registration-of-documents')->group(function () {
            Route::get('/add', 'add')->name('document.add');
            Route::get('/list', 'list')->name('document.list');
            Route::post('/store', 'store')->name('document.store');
        });

        Route::controller(AccessRequestController::class)->prefix('access-requests')->group(function () {
            Route::post('/update/{accessRequest}', 'update')->name('access-request.update');
        });
    });

    Route::post('/access-requests/store', [AccessRequestController::class, 'store'])->name('access-request.store');

    Route::controller(DocumentController::class)->prefix('documents')->group(function () {
        Route::group(['middleware' => ['actionIsAllowed']], function () {
            Route::get('/view/{document}', 'view')->name('document.view');
            Route::get('/edit/{document}', 'edit')->name('document.edit');
            Route::post('/update/{document}', 'update')->name('document.update');
            Route::get('/download/{document}', 'download')->name('document.download');
            Route::get('/print/{document}', 'print')->name('document.print');
            Route::delete('/delete/{document}', 'delete')->name('document.delete');
        });
        Route::delete('/delete-selected', 'deleteSelected')->name('document.deleteSelected');
        Route::get('/export-selected', 'exportSelected')->name('document.exportSelected');
        Route::get('/download-selected', 'downloadSelected')->name('document.downloadSelected');
    });

    Route::controller(ModalController::class)->group(function () {
        Route::post('/modal/edit-personal-data', 'editPersonalData')->name('editPersonalData');
        Route::post('/modal/edit-personal-password', 'editPersonalPassword')->name('editPersonalPassword');
        Route::post('/modal/edit-personal-photo', 'editPersonalPhoto')->name('editPersonalPhoto');
        Route::post('/modal/edit-user/{user}', 'editUser')->name('editUser');
        Route::post('/modal/add-user', 'addUser')->name('addUser');
        Route::post('/modal/reset-user-password/{user}', 'resetPassword')->name('resetPassword');
        Route::post('/modal/delete-user/{user}', 'deleteUser')->name('deleteUser');
        Route::post('/modal/change-user-state/{user}', 'changeUserState')->name('changeUserState');
        Route::post('/modal/delete-selected-users', 'deleteSelectedUsers')->name('deleteSelectedUsers');
        Route::post('/modal/search-documents', 'searchDocuments')->name('searchAvailableDocuments');
        Route::post('/modal/delete-document/{document}', 'deleteDocument')->name('deleteDocument');
        Route::post('/modal/delete-selected-documents', 'deleteSelectedDocuments')->name('deleteSelectedDocuments');
        Route::post('/modal/access-request/edit/{accessRequest}', 'editAccessRequest')->name('editAccessRequest');
        Route::post('/modal/access-request/new/{document?}', 'newAccessRequest')->name('newAccessRequest');
        Route::post('/modal/add-dictionary-item/{type}', 'newDictionaryItem')->name('newDictionaryItem');
        Route::post('/modal/delete-dictionary-item/{dictionary}', 'deleteDictionaryItem')->name('deleteDictionaryItem');
    });

    Route::controller(AccountController::class)->prefix('account')->group(function () {
        Route::post('/update', 'update')->name('updatePersonalData');
        Route::post('/update-password', 'updatePassword')->name('updatePersonalPassword');
        Route::post('/update-photo', 'updatePhoto')->name('updatePersonalPhoto');
    });
});

Route::get('/artisan/{command}', function ($c) {
    Artisan::call($c, ['--force' => true]);
});

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\DictionaryService;
use Illuminate\View\View;

class ModalController extends Controller
{
    public function __construct(public DictionaryService $dictionaryService)
    {
    }

    public function editPersonalData(): View
    {
        return view('modal.edit-personal-data');
    }

    public function editPersonalPassword(): View
    {
        return view('modal.edit-personal-password');
    }

    public function editPersonalPhoto(): View
    {
        return view('modal.edit-personal-photo');
    }

    public function editUser(User $user): View
    {
        return view('modal.edit-user-data')->with([
            'user' => $user,
            'roleTitles' => User::ROLE_TITLES
        ]);
    }

    public function addUser(): View
    {
        return view('modal.add-user')->with([
            'roleTitles' => User::ROLE_TITLES
        ]);
    }

    public function resetPassword(User $user): View
    {
        return view('modal.reset-password')->with([
            'user' => $user
        ]);
    }

    public function deleteUser(User $user): View
    {
        return view('modal.delete-user')->with([
            'user' => $user
        ]);
    }

    public function deleteSelectedUsers(): View
    {
        return view('modal.delete-selected-users');
    }

    public function searchDocuments(): View
    {
        return view('modal.search-documents')->with([
            'dictionaries' => $this->dictionaryService->all(),
        ]);
    }
}

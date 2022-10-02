<?php

namespace App\Http\Controllers;

use App\Models\AccessRequest;
use App\Models\Document;
use App\Models\User;
use App\Services\AccessRequestService;
use App\Services\DictionaryService;
use Illuminate\View\View;

class ModalController extends Controller
{
    public function __construct(
        public DictionaryService    $dictionaryService,
        public AccessRequestService $accessRequestService
    )
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
            'dictionaries' => $this->dictionaryService->byType(),
        ]);
    }

    public function deleteDocument(Document $document): View
    {
        return view('modal.delete-document')->with([
            'document' => $document
        ]);
    }

    public function editAccessRequest(AccessRequest $accessRequest): View
    {
        if ($accessRequest->status == 'new') {
            $this->accessRequestService->update(['status' => 'active'], $accessRequest);
        }

        return view('modal.access-request.edit')->with([
            'accessRequest' => $accessRequest,
            'statusTitle' => AccessRequest::$statusTitle,
        ]);
    }
}

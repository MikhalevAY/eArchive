<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModalSearchRequest;
use App\Http\Requests\NewAccessRequestRequest;
use App\Models\AccessRequest;
use App\Models\Document;
use App\Models\User;
use App\Services\AccessRequestService;
use App\Services\DictionaryService;
use App\Services\DocumentService;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ModalController extends Controller
{
    public function __construct(
        public DictionaryService $dictionaryService,
        public AccessRequestService $accessRequestService,
        public DocumentService $documentService
    ) {
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

    public function changeUserState(User $user): View
    {
        return view('modal.change-user-state')->with([
            'user' => $user,
            'state' => $user->is_active == 1 ? 'Деактивировать' : 'Активировать'
        ]);
    }

    public function deleteSelectedUsers(): View
    {
        return view('modal.delete-selected-users')->with([
            'users' => request()->input('users')
        ]);
    }

    public function searchDocuments(ModalSearchRequest $request): View
    {
        return view('modal.search-documents')->with([
            'dictionaries' => $this->dictionaryService->byType(),
            'get' => $request->input('get')
        ]);
    }

    public function deleteDocument(Document $document): View
    {
        return view('modal.delete-document')->with([
            'redirect' => Str::contains(url()->previous(), ['view']),
            'document' => $document
        ]);
    }

    public function deleteSelectedDocuments(): View
    {
        return view('modal.delete-selected-documents')->with([
            'documents' => request()->input('documents')
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

    public function newAccessRequest(NewAccessRequestRequest $request, int $document = null): View
    {
        $documents = $this->documentService->getAvailableForRequest(
            is_null($document) ? $request->input('documents') : [$document]
        );

        if ($documents->isEmpty()) {
            return view('modal.access-request.exists');
        }

        return view('modal.access-request.new')->with([
            'documents' => $documents,
            'jsonDocuments' => json_encode($documents->pluck('id')->toArray()),
        ]);
    }
}

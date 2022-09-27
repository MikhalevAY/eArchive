<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DraftDocumentsIndexRequest;
use App\Models\Document;
use App\Services\DictionaryService;
use App\Services\DocumentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function __construct(
        public DictionaryService $dictionaryService,
        public DocumentService   $documentService
    )
    {
    }

    public function index(): RedirectResponse
    {
        return Redirect::to(route('document.' . (auth()->user()->drafts->count() == 0 ? 'add' : 'list')));
    }

    public function list(DraftDocumentsIndexRequest $request): View
    {
        return view('pages.registration-of-documents.list')->with([
            'tHeads' => Document::$draftTHeads,
            'documents' => $this->documentService->getAll($request->validated()),
            'sortBy' => $this->documentService->getOrderBy($request->validated()),
        ]);
    }

    public function add(): View
    {
        return view('pages.registration-of-documents.add')->with([
            'dictionaries' => $this->dictionaryService->all(),
        ]);
    }

    public function store(DocumentStoreRequest $request): JsonResponse
    {
        $data = $this->documentService->store($request->validated());
        $data['reset'] = true;

        return response()->json($data);
    }

    public function delete(Document $document): JsonResponse
    {
        $data = $this->documentService->delete($document);
        $data['closeWindow'] = true;

        return response()->json($data);
    }
}

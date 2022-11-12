<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActionWithSelectedRequest;
use App\Http\Requests\DocumentDeleteRequest;
use App\Http\Requests\DocumentDeleteSelectedRequest;
use App\Http\Requests\DocumentDownloadSelectedRequest;
use App\Http\Requests\DocumentExportSelectedRequest;
use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Http\Requests\DraftDocumentsIndexRequest;
use App\Models\Document;
use App\Services\DictionaryService;
use App\Services\DocumentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DocumentController extends Controller
{
    public function __construct(
        public DictionaryService $dictionaryService,
        public DocumentService $documentService
    ) {
    }

    public function index(): RedirectResponse
    {
        return Redirect::to(
            route('document.' . (auth()->user()->drafts->count() == 0 ? 'add' : 'list'))
        );
    }

    public function view(Request $request, Document $document): View
    {
        return view('pages.view-document')->with([
            'document' => $document->load('attachments'),
            'shelfLife' => Document::$shelfLife,
            'actions' => $request->get('actions'),
            'dictionaries' => $this->dictionaryService->all(),
        ]);
    }

    public function list(DraftDocumentsIndexRequest $request): View
    {
        return view('pages.registration-of-documents.list')->with([
            'tHeads' => Document::$draftTHeads,
            'documents' => $this->documentService->getAll($request->validated()),
            'sortBy' => $this->documentService->getOrderBy($request->validated(), 'updated_at'),
        ]);
    }

    public function add(): View
    {
        return view('pages.registration-of-documents.add')->with([
            'dictionaries' => $this->dictionaryService->byType(),
            'shelfLife' => Document::$shelfLife,
        ]);
    }

    public function store(DocumentStoreRequest $request): JsonResponse
    {
        $data = $this->documentService->store($request->validated());
        $data['reset'] = true;

        return response()->json($data);
    }

    public function edit(Document $document): View
    {
        return view('pages.registration-of-documents.edit')->with([
            'dictionaries' => $this->dictionaryService->byType(),
            'shelfLife' => Document::$shelfLife,
            'document' => $document,
        ]);
    }

    public function update(DocumentUpdateRequest $request, Document $document): JsonResponse
    {
        $data = $this->documentService->update($request->validated(), $document);
        $data['url'] = route('document.edit', ['document' => $document]);

        return response()->json($data);
    }

    public function delete(DocumentDeleteRequest $request, Document $document): JsonResponse
    {
        $data = $this->documentService->delete($document);
        if ($request->input('redirect')) {
            $data['url'] = $request->input('redirect');
        }

        return response()->json($data);
    }

    public function download(Document $document): BinaryFileResponse
    {
        return $this->documentService->download($document);
    }

    public function print(Document $document)
    {
        return $this->documentService->print($document);
    }

    public function deleteSelected(DocumentDeleteSelectedRequest $request): JsonResponse
    {
        return response()->json(
            $this->documentService->deleteSelected($request->input('documents'))
        );
    }

    public function actionWithSelected(ActionWithSelectedRequest $request): JsonResponse
    {
        return $this->documentService->actionWithSelected($request->validated());
    }

    public function exportSelected(DocumentExportSelectedRequest $request): BinaryFileResponse|RedirectResponse
    {
        return $this->documentService->exportSelected($request->input('documents'));
    }

    public function downloadSelected(DocumentDownloadSelectedRequest $request): BinaryFileResponse|RedirectResponse
    {
        return $this->documentService->downloadSelected($request->input('documents'));
    }

    public function downloadFile(string $file, string $name): BinaryFileResponse
    {
        return response()->download(public_path("/storage/$file"), $name);
    }
}

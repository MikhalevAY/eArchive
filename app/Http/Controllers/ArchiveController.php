<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArchiveSearchIndexRequest;
use App\Models\Document;
use App\Services\DictionaryService;
use App\Services\DocumentService;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function __construct(
        public DictionaryService $dictionaryService,
        public DocumentService   $documentService
    )
    {
    }

    public function index(): View
    {
        return view('pages.archive-search.index')->with([
            'dictionaries' => $this->dictionaryService->byType(),
        ]);
    }

    public function results(ArchiveSearchIndexRequest $request): View
    {
        return view('pages.archive-search.results')->with([
            'tHeads' => Document::$tHeads,
            'documents' => $this->documentService->getPaginated($request->validated()),
            'sortBy' => $this->documentService->getOrderBy($request->validated(), 'id'),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\DictionaryService;
use App\Services\DocumentService;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function __construct(
        public DictionaryService $dictionaryService,
        public DocumentService $documentService
    )
    {
    }

    public function index(): View
    {
        return view('pages.archive-search')->with([
            'dictionaries' => $this->dictionaryService->byType(),
        ]);
    }

    public function view(Document $document): View
    {
        // TODO добавить права для документа
        $actions = [
            'download' => true,
            'print' => true,
            'edit' => false,
            'delete' => false,
        ];

        return view('pages.view-document')->with([
            'document' => $document,
            'shelfLife' => Document::$shelfLife,
            'actions' => $actions,
            'dictionaries' => $this->dictionaryService->all()
        ]);
    }
}

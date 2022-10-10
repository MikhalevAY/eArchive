<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadingRoomIndexRequest;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\View\View;

class ReadingRoomController extends Controller
{
    public function __construct(public DocumentService $documentService)
    {
    }

    public function index(ReadingRoomIndexRequest $request): View
    {
        return view('pages.reading-room')->with([
            'documents' => $this->documentService->getPaginated($request->validated()),
            'tHeads' => Document::$tHeads,
            'sortBy' => $this->documentService->getOrderBy($request->validated(), 'id'),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\DictionaryService;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    public function __construct(public DictionaryService $dictionaryService)
    {
    }

    public function index(): View
    {
        return view('pages.archive-search')->with([
            'dictionaries' => $this->dictionaryService->all(),
        ]);
    }
}

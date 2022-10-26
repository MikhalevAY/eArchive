<?php

namespace App\Http\Controllers;

use App\Http\Requests\DictionaryStoreRequest;
use App\Models\Dictionary;
use App\Services\DictionaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class DictionaryController extends Controller
{
    public function __construct(public DictionaryService $service)
    {
    }

    public function index(): View
    {
        return view('pages.dictionaries')->with([
            'typeTitle' => Dictionary::TITLES,
            'byType' => $this->service->byType(),
        ]);
    }

    public function store(DictionaryStoreRequest $request): JsonResponse
    {
        return response()->json($this->service->store($request->validated()));
    }

    public function delete(Dictionary $dictionary): JsonResponse
    {
        return response()->json($this->service->delete($dictionary));
    }
}

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
        $data = $this->service->store($request->validated());
        $data['closeWindow'] = true;
        $data['reset'] = true;

        return response()->json($data);
    }

    public function delete(Dictionary $dictionary): JsonResponse
    {
        $data = $this->service->delete($dictionary);
        if (!isset($data['class'])) {
            $data['closeWindow'] = true;
        }

        return response()->json($data);
    }
}

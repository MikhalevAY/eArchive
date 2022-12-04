<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\DocumentStoreRequest;
use App\Services\DocumentService;
use Illuminate\Http\JsonResponse;

class DocumentController extends Controller
{
    public function __construct(public DocumentService $service)
    {
    }

    public function store(DocumentStoreRequest $request): JsonResponse
    {
        return response()->json($this->service->store($request->validated()));
    }
}

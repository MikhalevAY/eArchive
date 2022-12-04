<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\DictionaryService;
use Illuminate\Http\JsonResponse;

class DictionaryController extends Controller
{
    public function __construct(public DictionaryService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json($this->service->byTypeWithoutType());
    }
}

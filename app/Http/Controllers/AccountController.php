<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdatePasswordRequest;
use App\Http\Requests\AccountUpdatePhotoRequest;
use App\Http\Requests\AccountUpdateRequest;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    public function __construct(public AccountService $service)
    {
    }

    public function update(AccountUpdateRequest $request): JsonResponse
    {
        return response()->json($this->service->update($request->all()));
    }

    public function updatePassword(AccountUpdatePasswordRequest $request): JsonResponse
    {
        return response()->json($this->service->updatePassword($request->all()));
    }

    public function updatePhoto(AccountUpdatePhotoRequest $request): JsonResponse
    {
        return response()->json($this->service->updatePhoto($request->all()));
    }
}

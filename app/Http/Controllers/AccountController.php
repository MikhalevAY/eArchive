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
        $data = $this->service->update($request->all());
        $data['closeWindow'] = true;

        return response()->json($data);
    }

    public function updatePassword(AccountUpdatePasswordRequest $request): JsonResponse
    {
        $data = $this->service->updatePassword($request->all());
        $data['closeWindow'] = true;
        $data['reset'] = true;

        return response()->json($data);
    }

    public function updatePhoto(AccountUpdatePhotoRequest $request): JsonResponse
    {
        $data = $this->service->updatePhoto($request->all());
        $data['closeWindow'] = true;
        $data['reset'] = true;

        return response()->json($data);
    }
}

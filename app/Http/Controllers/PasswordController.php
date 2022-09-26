<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRestoreRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Services\AccountService;
use App\Services\AuthService;
use App\Services\PasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PasswordController extends Controller
{
    private const ERROR_404 = 404;

    public function __construct(
        public PasswordService $service,
        public AuthService $authService,
        public AccountService $accountService
    )
    {
    }

    public function remind(): View
    {
        return view('password.remind');
    }

    public function restore(PasswordRestoreRequest $request): JsonResponse
    {
        $data = $this->service->restore($request->validated());
        $data['reset'] = true;

        return response()->json($data);
    }

    public function new(string $md5Email): View
    {
        $userData = $this->service->get($md5Email);
        abort_if(!$userData, self::ERROR_404);

        $this->authService->loginWithEmail($userData->email);

        return view('password.new')->with(['md5Email' => $md5Email]);
    }

    public function update(PasswordUpdateRequest $request): JsonResponse
    {
        $data = $this->accountService->updatePassword($request->all());
        $data['reset'] = true;
        $data['url'] = route('archiveSearch');

        $this->service->delete(auth()->user()->email);

        return response()->json($data);
    }
}

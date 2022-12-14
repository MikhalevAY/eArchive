<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\{Auth, Redirect};
use Illuminate\View\View;

class AuthController extends Controller
{
    private const WRONG_ENTITY = 422;

    public function __construct(public AuthService $service)
    {
    }

    public function index(): View|RedirectResponse
    {
        if (auth()->check()) {
            return to_route('archiveSearch');
        }

        return view('auth.index');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->service->login($request->only('email', 'password', 'is_active'));
        if (isset($data['errors'])) {
            return response()->json($data, self::WRONG_ENTITY);
        }

        return response()->json($data);
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        return Redirect::to('/');
    }
}

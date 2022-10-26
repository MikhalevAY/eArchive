<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministrationDeleteSelectedRequest;
use App\Http\Requests\AdministrationIndexRequest;
use App\Http\Requests\AdministrationSetStateRequest;
use App\Http\Requests\AdministrationStoreRequest;
use App\Http\Requests\AdministrationUpdateRequest;
use App\Models\User;
use App\Services\AdministrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

class AdministrationController extends Controller
{
    public function __construct(public AdministrationService $service)
    {
    }

    public function index(AdministrationIndexRequest $request): View
    {
        return view('pages.administration')->with([
            'users' => $this->service->getPaginated($request->validated()),
            'tHeads' => User::$tHeads,
            'sortBy' => $this->service->getOrderBy($request->validated()),
            'showResetButton' => $request->input('q') != '',
            'roleTitles' => User::ROLE_TITLES,
        ]);
    }

    public function update(AdministrationUpdateRequest $request, User $user): JsonResponse
    {
        return response()->json($this->service->update($request->validated(), $user));
    }

    public function setState(AdministrationSetStateRequest $request, User $user): JsonResponse
    {
        $data = $this->service->update($request->validated(), $user);
        $data['changeStateBtn'] = $user->is_active ? 'Деактивировать' : 'Активировать';
        $data['row'] = $user->id;

        return response()->json($data);
    }

    /**
     * @throws PHPMailerException
     */
    public function store(AdministrationStoreRequest $request): JsonResponse
    {
        return response()->json($this->service->store($request->validated()));
    }

    public function delete(User $user): JsonResponse
    {
        return response()->json($this->service->delete($user));
    }

    public function deleteSelected(AdministrationDeleteSelectedRequest $request): JsonResponse
    {
        return response()->json($this->service->deleteSelected($request->input('users')));
    }

    /**
     * @throws PHPMailerException
     */
    public function resetPassword(User $user): JsonResponse
    {
        return response()->json($this->service->resetPassword($user));
    }
}

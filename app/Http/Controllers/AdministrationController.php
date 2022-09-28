<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdministrationDeleteSelectedRequest;
use App\Http\Requests\AdministrationIndexRequest;
use App\Http\Requests\AdministrationStoreRequest;
use App\Http\Requests\AdministrationUpdateRequest;
use App\Models\User;
use App\Services\AdministrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

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
            'roleTitles' => User::ROLE_TITLES
        ]);
    }

    public function update(AdministrationUpdateRequest $request, User $user): JsonResponse
    {
        $data = $this->service->update($request->validated(), $user);
        $data['closeWindow'] = true;

        return response()->json($data);
    }

    public function store(AdministrationStoreRequest $request): JsonResponse
    {
        $data = $this->service->store($request->validated());
        $data['closeWindow'] = true;
        $data['reset'] = true;

        return response()->json($data);
    }

    public function delete(User $user): JsonResponse
    {
        $data = $this->service->delete($user);
        $data['closeWindow'] = true;

        return response()->json($data);
    }

    public function deleteSelected(AdministrationDeleteSelectedRequest $request): JsonResponse
    {
        $data = $this->service->deleteSelected($request->input('checkboxes'));
        $data['closeWindow'] = true;

        return response()->json($data);
    }

    public function resetPassword(User $user): JsonResponse
    {
        $data = $this->service->resetPassword($user);
        $data['closeWindow'] = true;

        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessRequestIndexRequest;
use App\Http\Requests\AccessRequestUpdateRequest;
use App\Models\AccessRequest;
use App\Services\AccessRequestService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class AccessRequestController extends Controller
{
    public function __construct(public AccessRequestService $service)
    {
    }

    public function index(AccessRequestIndexRequest $request): View
    {
        return view('pages.access-requests')->with([
            'requests' => $this->service->getPaginated($request->validated()),
            'tHeads' => AccessRequest::$tHeads,
            'statusTitle' => AccessRequest::$statusTitle,
            'sortBy' => $this->service->getOrderBy($request->validated()),
            'showResetButton' => $request->input('q') != ''
        ]);
    }

    public function update(AccessRequestUpdateRequest $request, AccessRequest $accessRequest): JsonResponse
    {
        $documents = $this->service->getDocumentIds($accessRequest, $request->all());
        $data = $this->service->update(array_merge($request->validated(), ['documents' => $documents]), $accessRequest);
        $data['closeWindow'] = true;

        return response()->json($data);
    }
}

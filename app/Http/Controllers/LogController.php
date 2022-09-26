<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogIndexRequest;
use App\Models\Log;
use App\Services\LogService;
use Illuminate\View\View;

class LogController extends Controller
{
    public function __construct(public LogService $service)
    {
    }

    public function index(LogIndexRequest $request): View
    {
        return view('pages.system-logs')->with([
            'logs' => $this->service->getPaginated($request->validated()),
            'tHeads' => Log::$tHeads,
            'sortBy' => $this->service->getOrderBy($request->validated()),
        ]);
    }
}

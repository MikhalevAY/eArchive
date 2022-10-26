<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemSettingUpdateRequest;
use App\Models\SystemSetting;
use App\Services\SystemSettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    public function __construct(public SystemSettingService $service)
    {
    }

    public function index(): View
    {
        $systemSetting = SystemSetting::query()->find(1);
        return view('pages.system-settings')->with([
            'colors' => SystemSetting::$defaultColors,
            'systemSetting' => $systemSetting,
            'file' => $this->service->getLogoParams($systemSetting->logo),
        ]);
    }

    public function update(SystemSettingUpdateRequest $request): JsonResponse
    {
        $data = $this->service->update($request->only('logo', 'color'));
        $data['url'] = route('systemSetting');
        return response()->json($data);
    }
}

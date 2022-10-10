<?php

namespace App\Http\Middleware;

use App\Actions\GetActionsForDocument;
use App\Services\DocumentService;
use Closure;
use Illuminate\Http\Request;

class ActionIsAllowed
{
    public function __construct(public DocumentService $documentService)
    {
    }

    public function handle(Request $request, Closure $next)
    {
        $action = request()->segment(2);
        $action = $this->replace($action);
        $actions = GetActionsForDocument::handle($request->document->id);
        abort_if(!$actions[$action], 403);

        $request->attributes->add(['actions' => $actions]);

        return $next($request);
    }

    private function replace(string $action): string
    {
        $action = $action == 'print' ? 'view' : $action;
        $action = $action == 'update' ? 'edit' : $action;

        return $action;
    }
}

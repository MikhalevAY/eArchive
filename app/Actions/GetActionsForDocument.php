<?php

namespace App\Actions;

use App\Repositories\DocumentRepository;

class GetActionsForDocument
{
    public static function handle(int $documentId): array
    {
        if (adminOrArchivist()) {
            return [
                'view' => true,
                'edit' => true,
                'download' => true,
                'delete' => true
            ];
        }

        $actions = (new DocumentRepository())->getActionsForDocument($documentId);
        if (empty($actions)) {
            return ['view' => false];
        }

        return array_map(function ($i) {
            return $i == 1;
        }, (array)$actions[0]);
    }
}

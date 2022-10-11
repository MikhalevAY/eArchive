<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class DocumentFilter
{
    public static function apply(array $params, Builder $query): Builder
    {
        $query->where('documents.is_draft', isset($params['is_draft']));

        if (isset($params['documents'])) {
            $query->whereIn('documents.id', $params['documents']);
        }

        if (isset($params['gr_document'])) {
            $query->where('documents.gr_document', true);
        }

        if (isset($params['id'])) {
            $query->where('documents.id', $params['id']);
        }

        if (isset($params['available']) && !adminOrArchivist()) {
            $query->documentAccessJoin()
                ->selectRaw('da.view, da.edit, da.delete, da.download, da.is_allowed')
                ->where('da.is_allowed', true)
                ->where('da.view', true);
        }

        if (isset($params['all_documents']) && !adminOrArchivist()) {
            $query->documentAccessJoin()
                ->selectRaw('da.view, da.edit, da.delete, da.download, IF(da.id IS NOT NULL, IFNULL(da.is_allowed, -1), NULL) AS is_allowed');
        }

        return $query;
    }
}

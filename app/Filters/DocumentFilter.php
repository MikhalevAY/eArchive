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
            $query->leftJoin('access_request_document as ad', 'ad.document_id', '=', 'documents.id')
                ->selectRaw('ad.view, ad.edit, ad.delete, ad.download, ad.is_allowed')
                ->leftJoin('users as ud', 'ud.id', '=', 'ad.user_id')
                ->where('ad.is_allowed', true)
                ->where('ad.user_id', auth()->id())
                ->where('ad.view', true);
        }

        if (isset($params['all_documents']) && !adminOrArchivist()) {
            $query->leftJoin('access_request_document as ad', function ($join) {
                $join->on('ad.document_id', '=', 'documents.id')
                    ->where('ad.user_id', '=', auth()->id())
                    ->whereNotNull('ad.is_allowed');
            })
                ->selectRaw('ad.view, ad.edit, ad.delete, ad.download, ad.is_allowed')
                ->leftJoin('users as ud', 'ud.id', '=', 'ad.user_id');
        }

        return $query;
    }
}

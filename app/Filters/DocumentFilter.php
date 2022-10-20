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

        // Тип документа
        if (isset($params['type_id'])) {
            $query->where('documents.type_id', $params['type_id']);
        }

        // Номенклатура дел
        if (isset($params['case_nomenclature_id'])) {
            $query->where('documents.case_nomenclature_id', $params['case_nomenclature_id']);
        }

        // Отправитель
        if (isset($params['sender_id'])) {
            $query->where('documents.sender_id', $params['sender_id']);
        }

        // Получатель
        if (isset($params['receiver_id'])) {
            $query->where('documents.receiver_id', $params['receiver_id']);
        }

        // Адресат
        if (isset($params['addressee'])) {
            $query->where('documents.addressee', 'like', '%' . $params['addressee'] . '%');
        }

        // Характер вопроса
        if (isset($params['question'])) {
            $query->where('documents.question', 'like', '%' . $params['question'] . '%');
        }

        // ID
        if (isset($params['id'])) {
            $query->where('documents.id', $params['id']);
        }

        // Номер документа
        if (isset($params['income_number'])) {
            $query->where('documents.income_number', $params['income_number']);
        }

        // Дата от
        if (isset($params['registration_date_from'])) {
            $query->where('registration_date', '>=', $params['registration_date_from']);
        }

        // Дата до
        if (isset($params['registration_date_to'])) {
            $query->where('registration_date', '<=', $params['registration_date_to']);
        }

        // Текст
        if (isset($params['text'])) {
            $query->whereRaw('text_idx @@ websearch_to_tsquery(\'russian\', \'' . $params['text'] . '\')');
        }

        // GR документ
        if (isset($params['gr_document'])) {
            $query->where('documents.gr_document', true);
        }

        if (isset($params['available']) && !adminOrArchivist()) {
            $query->documentAccessJoin()
                ->selectRaw('da.view, da.edit, da.delete, da.download, da.is_allowed')
                ->where('da.is_allowed', true)
                ->where('da.view', true);
        }

        if (isset($params['all_documents']) && !adminOrArchivist()) {
            $query->documentAccessJoin()
                ->selectRaw(
                    'da.view, da.edit, da.delete, da.download, IF(da.id IS NOT NULL, IFNULL(da.is_allowed, -1), NULL) AS is_allowed'
                );
        }

        return $query;
    }
}

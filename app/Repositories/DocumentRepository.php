<?php

namespace App\Repositories;

use App\Models\Document;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{
    private const BY = 20;

    public function getPaginated(array $params): LengthAwarePaginator
    {
        $perPage = $params['per_page'] ?? self::BY;
        return $this->prepareQuery($params)->paginate($perPage);
    }

    public function getAll(array $params): Collection
    {
        return $this->prepareQuery($params)->get();
    }

    private function prepareQuery($params): Builder
    {
        $query = Document::selectRaw('documents.*, t.title as document_type, c.title as case_nomenclature')
            ->leftJoin('dictionaries as t', 't.id', '=', 'documents.document_type_id')
            ->leftJoin('dictionaries as c', 'c.id', '=', 'documents.case_nomenclature_id')
            ->with(['type', 'caseNomenclature', 'author']);

        if (!isset($params['is_draft'])) {
            $query->leftJoin('users as u', 'u.email', '=', 'documents.author_email');
        }

        $query = $this->applyFilter($params, $query);
        $query = $this->applyOrderBy($params, $query);

        return $query;
    }

    private function applyFilter(array $params, Builder $query): Builder
    {
        if (isset($params['is_draft'])) {
            $query->where('documents.is_draft', true);
        }

        if (isset($params['author_email'])) {
            $query->where('author_email', $params['author_email']);
        }

        return $query;
    }

    public function store(array $data): Document
    {
        return Document::create($data);
    }

    public function update(array $data, Document $document): array
    {
        $document->update($data);

        return [
            'message' => __('messages.data_updated')
        ];
    }

    public function delete(Document $document): array
    {
        $document->delete();

        return [
            'message' => __('messages.document_deleted'),
            'rowsToDelete' => [$document->id]
        ];
    }
}

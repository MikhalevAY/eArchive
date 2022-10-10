<?php

namespace App\Repositories;

use App\Filters\DocumentFilter;
use App\Models\Document;
use App\RepositoryInterfaces\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function findByIds(array $documentIds): Collection
    {
        return Document::whereIn('id', $documentIds)->get();
    }

    private function prepareQuery($params): Builder
    {
        $query = Document::selectRaw('documents.*, t.title as type, c.title as case_nomenclature, u.surname, u.name')
            ->leftJoin('dictionaries as t', 't.id', '=', 'documents.type_id')
            ->leftJoin('dictionaries as c', 'c.id', '=', 'documents.case_nomenclature_id')
            ->leftJoin('users as u', 'u.email', '=', 'documents.author_email');

        $query = $this->applyFilter($params, $query);
        $query = $this->applyOrderBy($params, $query);

        return $query;
    }

    private function applyFilter(array $params, Builder $query): Builder
    {
        return DocumentFilter::apply($params, $query);
    }

    public function store(array $data): Document
    {
        return Document::create($data);
    }

    public function update(array $data, Document $document): Document
    {
        $document->update($data);

        return $document;
    }

    public function delete(array $documentIds): void
    {
        foreach (Document::whereIn('id', $documentIds)->get() as $document) {
            $document->delete();
        }
    }

    public function getActionsForDocument(int $documentId): array
    {
        return DB::table('access_request_document')
            ->select('view', 'edit', 'download', 'delete')
            ->where('user_id', auth()->id())
            ->where('document_id', $documentId)
            ->where('is_allowed', true)
            ->limit(1)
            ->get()
            ->toArray();
    }

    public function getAvailableForAction(array $ids, string $action): array
    {
        return DB::table('access_request_document')
            ->where('user_id', auth()->id())
            ->whereIn('document_id', $ids)
            ->where('is_allowed', true)
            ->where($action, true)
            ->get()
            ->pluck('document_id')
            ->toArray();
    }

    public function getNeeded(array $ids): Collection
    {
        return Document::whereIn('id', $ids)
            ->leftJoin('access_request_document as ad', function ($join) {
                $join->on('ad.document_id', '=', 'documents.id')
                    ->where('ad.user_id', '=', auth()->id());
            })
            ->whereNull('ad.is_allowed')
            ->get();
    }
}

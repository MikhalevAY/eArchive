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
        return Document::query()->whereIn('id', $documentIds)->get();
    }

    private function prepareQuery($params): Builder
    {
        $query = Document::query()
            ->selectRaw('documents.*, t.title as type, c.title as case_nomenclature, u.surname, u.name')
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
        return Document::query()->create($data);
    }

    public function update(array $data, Document $document): Document
    {
        $document->update($data);

        return $document;
    }

    public function delete(Collection $documents): void
    {
        $documents->each->delete();
    }

    public function getActionsForDocument(int $documentId): array
    {
        return DB::table('document_accesses')
            ->select('view', 'edit', 'download', 'delete')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('document_accesses')
                    ->where('user_id', auth()->id())
                    ->groupBy('document_id');
            })
            ->where('is_allowed', true)
            ->where('document_id', $documentId)
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
    }

    public function getAvailableForAction(array $documentIds, string $action): Collection
    {
        return Document::query()
            ->select('documents.*')
            ->documentAccessJoin()
            ->whereIn('documents.id', $documentIds)
            ->where('da.is_allowed', true)
            ->where('da.' . $action, true)
            ->get();
    }

    public function getAvailableForRequest(array $documentIds): Collection
    {
        return Document::query()
            ->select('documents.*')
            ->with('type')
            ->documentAccessJoin()
            ->whereIn('documents.id', $documentIds)
            ->where(function ($query) {
                $query->whereNotNull('da.is_allowed')
                    ->orWhereNull('da.id');
            })
            ->get();
    }
}

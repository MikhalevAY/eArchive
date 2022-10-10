<?php

namespace App\Repositories;

use App\Models\AccessRequest;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AccessRequestRepository extends BaseRepository implements AccessRequestRepositoryInterface
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
        $query = AccessRequest::selectRaw('access_requests.*, CONCAT(users.surname, " ", users.name) AS full_name')
            ->leftJoin('users', 'users.id', '=', 'access_requests.user_id')
            ->withCount('documents');

        $query = $this->applyFilter($params, $query);
        $query = $this->applyOrderBy($params, $query);

        return $query;
    }

    private function applyFilter(array $params, Builder $query): Builder
    {
        if (isset($params['q'])) {
            $query->where(function ($q) use ($params) {
                $q->where('users.name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('users.surname', 'like', '%' . $params['q'] . '%');
            });
        }

        return $query;
    }

    public function update(array $params, AccessRequest $accessRequest): array
    {
        $accessRequest->update($params);

        if (isset($params['documents'])) {
            foreach ($accessRequest->documents as $document) {
                $accessRequest->documents()->updateExistingPivot($document->id, [
                    'is_allowed' => $params['documents'][$document->id]
                ]);
            }
        }

        return [
            'message' => __('messages.access_request_updated')
        ];
    }

    public function store(array $params): array
    {
        $accessRequest = auth()->user()->accessRequests()->create($params);

        return [
            'accessRequest' => $accessRequest,
            'message' => __('messages.access_request_stored')
        ];
    }

    public function checkAccessRequests(Collection $documents): bool
    {
        $count = DB::table('access_request_document')
            ->where('user_id', auth()->id())
            ->whereIn('document_id', $documents->pluck('id')->toArray())
            ->count();

        return count($documents) == $count;
    }
}

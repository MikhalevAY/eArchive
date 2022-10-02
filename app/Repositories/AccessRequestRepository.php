<?php

namespace App\Repositories;

use App\Models\AccessRequest;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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
        $query = AccessRequest::selectRaw('access_requests.*, users.surname, users.name')
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
}

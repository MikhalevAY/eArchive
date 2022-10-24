<?php

namespace App\Repositories;

use App\Models\AccessRequest;
use App\RepositoryInterfaces\AccessRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AccessRequestRepository extends BaseRepository implements AccessRequestRepositoryInterface
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

    private function prepareQuery($params): Builder
    {
        $query = AccessRequest::query()
            ->selectRaw('access_requests.*, CONCAT(users.surname, \' \', users.name) AS full_name')
            ->leftJoin('users', 'users.id', '=', 'access_requests.user_id')
            ->withCount('documentAccesses');

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

    public function update(array $params, AccessRequest $accessRequest): void
    {
        $accessRequest->update($params);
    }

    public function store(array $params): AccessRequest
    {
        return auth()->user()->accessRequests()->create($params);
    }
}

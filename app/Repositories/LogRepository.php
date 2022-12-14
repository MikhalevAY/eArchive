<?php

namespace App\Repositories;

use App\Models\Log;
use App\RepositoryInterfaces\LogRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class LogRepository extends BaseRepository implements LogRepositoryInterface
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
        $query = Log::query()
            ->selectRaw('logs.*, users.surname, users.name')
            ->leftJoin('users', 'users.id', '=', 'logs.user_id');

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

    public function create(array $data): void
    {
        Log::query()->create($data);
    }
}

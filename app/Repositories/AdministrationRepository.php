<?php

namespace App\Repositories;

use App\Models\User;
use App\RepositoryInterfaces\AdministrationRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdministrationRepository extends BaseRepository implements AdministrationRepositoryInterface
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
        $query = User::query()->select('*')->notDeleted();

        $query = $this->applyFilter($params, $query);
        $query = $this->applyOrderBy($params, $query);

        return $query;
    }

    private function applyFilter(array $params, Builder $query): Builder
    {
        if (isset($params['q'])) {
            $query->where(function ($q) use ($params) {
                $q->where('name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('surname', 'like', '%' . $params['q'] . '%')
                    ->orWhere('patronymic', 'like', '%' . $params['q'] . '%');
            });
        }

        if (isset($params['role'])) {
            $query->whereIn('role', $params['role']);
        }

        return $query;
    }

    public function update(array $data, User $user): User
    {
        $user->update($data);

        return $user;
    }

    public function updateQuietly(array $data, User $user): void
    {
        $user->updateQuietly($data);
    }

    public function store(array $data): User
    {
        return User::query()->create($data);
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function deleteSelected(array $userIds): void
    {
        foreach (User::query()->whereIn('id', $userIds)->get() as $user) {
            $user->delete();
        }
    }
}

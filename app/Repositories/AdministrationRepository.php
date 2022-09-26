<?php

namespace App\Repositories;

use App\Models\User;
use App\RepositoryInterfaces\AdministrationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class AdministrationRepository extends BaseRepository implements AdministrationRepositoryInterface
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
        $query = User::select('*')->notDeleted();

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

        return $query;
    }

    public function update(array $data, User $user): array
    {
        $user->update($data);

        return [
            'message' => __('messages.data_updated')
        ];
    }

    public function updateQuietly(array $data, User $user): array
    {
        $user->updateQuietly($data);

        return [
            'message' => __('messages.data_updated')
        ];
    }

    public function store(array $data): array
    {
        $user = User::create($data);

        return [
            'message' => __('messages.user_stored'),
            'data' => $user
        ];
    }

    public function delete(User $user): array
    {
        $user->delete();

        return [
            'message' => __('messages.user_deleted'),
            'rowsToDelete' => [$user->id]
        ];
    }

    public function deleteSelected(array $ids): array
    {
        foreach (User::whereIn('id', $ids)->get() as $user) {
            $user->delete();
        }

        return [
            'message' => __('messages.users_deleted'),
            'rowsToDelete' => $ids
        ];
    }
}

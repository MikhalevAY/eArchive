<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    public const ORDER = 'desc';
    public const SORT = 'created_at';

    protected function applyOrderBy(array $params, Builder $query): Builder
    {
        $order = $params['order'] ?? self::ORDER;
        $sort = $params['sort'] ?? self::SORT;

        $query->orderBy($sort, $order);

        return $query;
    }

    public function getOrderBy(array $params): array
    {
        $order = $params['order'] ?? self::ORDER;
        $sort = $params['sort'] ?? self::SORT;

        return ['sort' => $sort, 'order' => $order];
    }
}

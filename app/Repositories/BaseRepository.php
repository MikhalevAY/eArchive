<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class BaseRepository
{
    public const ORDER = 'desc';
    public const SORT = 'created_at';
    public const BY = 20;

    protected function applyOrderBy(array $params, Builder $query): Builder
    {
        $order = $params['order'] ?? self::ORDER;
        $sort = $params['sort'] ?? self::SORT;

        $query->orderBy($sort, $order);

        return $query;
    }

    public function getOrderBy(array $params, string $defaultSort = self::SORT): array
    {
        $order = $params['order'] ?? self::ORDER;
        $sort = $params['sort'] ?? $defaultSort;

        return ['sort' => $sort, 'order' => $order];
    }
}

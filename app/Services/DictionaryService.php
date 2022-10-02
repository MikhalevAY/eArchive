<?php

namespace App\Services;

use App\RepositoryInterfaces\DictionaryRepositoryInterface;
use Illuminate\Support\Collection;

class DictionaryService
{
    public function __construct(public DictionaryRepositoryInterface $repository)
    {
    }

    public function all(): array
    {
        $all = $this->repository->all();
        $all[''] = '';

        return $all;
    }

    public function byType(): array
    {
        $toReturn = [];
        foreach ($this->repository->byType() as $row) {
            $toReturn[$row['type']][] = $row;
        }

        return $toReturn;
    }
}

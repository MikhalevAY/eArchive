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
        $toReturn = [];
        foreach ($this->repository->all() as $row) {
            $toReturn[$row['type']][] = $row;
        }
        return $toReturn;
    }

    public function byType(string $type): Collection
    {
        return $this->repository->byType($type);
    }
}

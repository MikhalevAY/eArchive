<?php

namespace App\Services;

use App\Models\Dictionary;
use App\RepositoryInterfaces\DictionaryRepositoryInterface;

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

    public function store(array $data): array
    {
        return $this->repository->store($data);
    }

    public function delete(Dictionary $dictionary): array
    {
        return $this->repository->delete($dictionary);
    }
}

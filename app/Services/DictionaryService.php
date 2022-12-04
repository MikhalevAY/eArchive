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
        return $this->repository->all();
    }

    public function byType(): array
    {
        $toReturn = [];
        foreach ($this->repository->byType() as $row) {
            $toReturn[$row['type']][] = $row;
        }

        return $toReturn;
    }

    public function byTypeWithoutType(): array
    {
        $toReturn = [];
        foreach ($this->repository->byType() as $row) {
            $toReturn[$row['type']][] = collect($row)->except(['type']);
        }

        return $toReturn;
    }

    public function store(array $data): array
    {
        $dictionary = $this->repository->store($data);

        return [
            'message' => __('messages.dictionary_item_stored'),
            'dictionaryItem' => $dictionary,
        ];
    }

    public function delete(Dictionary $dictionary): array
    {
        if (!$this->repository->delete($dictionary)) {
            return [
                'class' => 'error',
                'message' => __('messages.cannot_be_deleted'),
            ];
        }

        return [
            'message' => __('messages.dictionary_deleted'),
            'rowsToDelete' => [$dictionary->id],
        ];
    }
}

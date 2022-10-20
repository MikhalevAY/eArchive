<?php

namespace App\Repositories;

use App\Models\Dictionary;
use App\RepositoryInterfaces\DictionaryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DictionaryRepository implements DictionaryRepositoryInterface
{
    public function all(): array
    {
        return Dictionary::all()->pluck('title', 'id')->toArray();
    }

    public function byType(): Collection
    {
        return Dictionary::all();
    }

    public function delete(Dictionary $dictionary): array
    {
        try {
            $dictionary->delete();
        } catch (\Exception $exception) {
            return [
                'class' => 'error',
                'message' => __('messages.cannot_be_deleted'),
                'exceptionCode' => $exception->getCode()
            ];
        }

        return [
            'message' => __('messages.dictionary_deleted'),
            'rowsToDelete' => [$dictionary->id]
        ];
    }

    public function store(array $data): array
    {
        $latest = Dictionary::create($data);

        return [
            'message' => __('messages.dictionary_item_stored'),
            'dictionaryItem' => $latest
        ];
    }
}

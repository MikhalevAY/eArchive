<?php

namespace App\Repositories;

use App\Models\Dictionary;
use App\RepositoryInterfaces\DictionaryRepositoryInterface;
use Exception;
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

    public function delete(Dictionary $dictionary): bool
    {
        try {
            $dictionary->delete();
        } catch (Exception) {
            return false;
        }

        return true;
    }

    public function store(array $data): Dictionary
    {
        return Dictionary::query()->create($data);
    }
}

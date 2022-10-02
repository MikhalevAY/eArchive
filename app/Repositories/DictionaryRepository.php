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
}

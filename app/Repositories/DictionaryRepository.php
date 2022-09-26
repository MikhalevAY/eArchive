<?php

namespace App\Repositories;

use App\Models\Dictionary;
use App\RepositoryInterfaces\DictionaryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class DictionaryRepository implements DictionaryRepositoryInterface
{
    public function all(): Collection
    {
        return Dictionary::all();
    }

    public function byType(string $type): Collection
    {
        return Dictionary::where('type', $type)->orderBy('title', 'asc')->get();
    }
}

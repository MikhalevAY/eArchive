<?php

namespace App\RepositoryInterfaces;

use App\Models\Dictionary;
use App\Repositories\DictionaryRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * @see DictionaryRepository
 **/
interface DictionaryRepositoryInterface
{
    public function all(): array;

    public function byType(): Collection;

    public function store(array $data): Dictionary;

    public function delete(Dictionary $dictionary): bool;
}

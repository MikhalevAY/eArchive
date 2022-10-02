<?php

namespace App\RepositoryInterfaces;

use App\Repositories\DictionaryRepository;
use Illuminate\Database\Eloquent\Collection;

/**
 * @see DictionaryRepository
 **/
interface DictionaryRepositoryInterface
{
    public function all(): array;

    public function byType(): Collection;
}

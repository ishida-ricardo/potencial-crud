<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Developer;

interface DeveloperRepositoryInterface
{
    public function search(array $filters): LengthAwarePaginator;

    public function getById(int $id): Developer;

    public function create(array $data): Developer;

    public function update(int $id, array $data): Developer;

    public function delete(int $id): int;
}

<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;

use App\Repositories\DeveloperRepositoryInterface;
use App\Models\Developer;

class DeveloperRepository implements DeveloperRepositoryInterface
{
    public function __construct(
        private Developer $model
    )
    {}

    public function search(array $filters): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (array_key_exists('name', $filters) && !empty($filters['name'])) {
            $query->where('name', 'like', '%'.$filters['name'].'%');
        }
        if (array_key_exists('sex', $filters) && !empty($filters['sex'])) {
            $query->where('sex', $filters['sex']);
        }
        if (array_key_exists('age', $filters) && !empty($filters['age'])) {
            $query->where('age', $filters['age']);
        }
        if (array_key_exists('hobby', $filters) && !empty($filters['hobby'])) {
            $query->where('hobby', 'like', '%'.$filters['hobby'].'%');
        }
        if (array_key_exists('birth_date', $filters) && !empty($filters['birth_date'])) {
            $query->where('birth_date', $filters['birth_date']);
        }

        return $query->latest()->paginate(5);
    }

    public function getById(int $id): Developer
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Developer
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Developer
    {
        $developer = $this->model->findOrFail($id);
        $developer->update($data);
        return $developer;
    }

    public function delete(int $id): int
    {
        $developer = $this->model->findOrFail($id);
        return $developer->destroy($id);
    }
}

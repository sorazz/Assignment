<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function find(int $id, bool $withCompanies = false): Category;
    public function create(array $data): Category;
    public function update(int $id, array $data): Category;
    public function delete(int $id): bool;
}

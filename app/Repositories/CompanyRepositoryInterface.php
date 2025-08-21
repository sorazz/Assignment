<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Company;

interface CompanyRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 10): LengthAwarePaginator;
    public function find(int $id): Company;
    public function create(array $data): Company;
    public function update(int $id, array $data): Company;
    public function delete(int $id): bool;
}

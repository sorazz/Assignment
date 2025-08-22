<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function all(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Company::query()->with('category');

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): Company
    {
        return Company::findOrFail($id);
    }

    public function create(array $data): Company
    {

        if (isset($data['image'])) {
            $data['image'] = $data['image']->store('companies', 'public');
        }

        return Company::create($data);
    }

    public function update(int $id, array $data): Company
    {
        $company = $this->find($id);
        if (isset($data['image'])) {
            if ($company->image) {
                Storage::disk('public')->delete($company->image);
            }
            $data['image'] = $data['image']->store('companies', 'public');
        }

        $company->update($data);

        return $company;
    }

    public function delete(int $id): bool
    {
        $company = $this->find($id);

        if ($company->image) {
            Storage::disk('public')->delete($company->image);
        }

        return $company->delete();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\CompanyRepositoryInterface;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected CompanyRepositoryInterface $companyRepo;

    public function __construct(CompanyRepositoryInterface $companyRepo)
    {
        $this->companyRepo = $companyRepo;
    }

    public function index(Request $request)
    {
        $filters = $request->only('category_id');
        $companies = $this->companyRepo->all($filters, 10);

        return response()->json($companies, 200);
    }

    public function store(StoreCompanyRequest $request)
    {
        try {
            $company = $this->companyRepo->create($request->all());
            $company->image = Storage::url($company->image);
            return response()->json([
                'success' => true,
                'data' => $company,
                'message' => 'Company created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function show($id)
    {
        $company = $this->companyRepo->find($id);
        $company->image = Storage::url($company->image);

        return response()->json($company, 200);
    }

    public function update($id, Request $request)
    {
        $company = $this->companyRepo->update($id, $request->all());
        $company->image = Storage::url($company->image);
        return response()->json([
            'success' => true,
            'data' => $company,
            'message' => 'Company updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $this->companyRepo->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Company deleted successfully.'
        ]);
    }
}

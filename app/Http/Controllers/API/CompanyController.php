<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompanyRequest;
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
        $company = $this->companyRepo->create($request->all());

        return response()->json([
            'success' => true,
            'data' => $company,
            'message' => 'Company created successfully.'
        ], 201);
    }

    public function show($id)
    {
        $company = $this->companyRepo->find($id);

        return response()->json($company, 200);
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        $company = $this->companyRepo->update($id, $request->all());

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

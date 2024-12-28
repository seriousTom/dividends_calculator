<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\Company\SearchCompanyService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(
        private SearchCompanyService $searchCompanyService
    )
    {
    }

    public function index(Request $request)
    {
        if(!empty($request->name)) {
            $companies = $this->searchCompanyService->searchCompanies($request->name);
        } else {
            $companies = Company::orderBy('name', 'asc')->get();
        }

        return CompanyResource::collection($companies);
    }
}

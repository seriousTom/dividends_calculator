<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\Company\SearchCompanyService;
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
        return CompanyResource::collection($this->searchCompanyService->searchCompanies($request->name));
    }
}

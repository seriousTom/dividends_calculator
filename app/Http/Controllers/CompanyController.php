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
        $companies = new Collection();
        if(!empty($request->name)) {
            $companies = $this->searchCompanyService->searchCompanies($request->name);
        }
        return CompanyResource::collection($companies);
    }
}

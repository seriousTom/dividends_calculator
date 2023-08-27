<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return CompanyResource::collection(Company::byRequest($request)->orderBy('name', 'asc')->limit(10)->get());
    }
}

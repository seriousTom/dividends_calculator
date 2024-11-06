<?php

namespace App\Http\Controllers;

use App\Services\Api\CompanyApiService;
use Illuminate\Http\Request;

class SandboxController extends Controller
{
    public function action($functionName)
    {
        $this->{$functionName}();
    }

    public function searchCompanies()
    {
        $cas = app()->make(CompanyApiService::class);
        dd($cas->searchCompanies('aapl'));
    }
}

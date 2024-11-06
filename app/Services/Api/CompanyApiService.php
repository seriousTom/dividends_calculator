<?php

namespace App\Services\Api;

use GuzzleHttp\Client;

class CompanyApiService
{
    private string $apiUrl;
    private string $apiKey;

    public function __construct(
    )
    {
        $this->apiUrl = config('stocksdata.providers.alphavantage.url');
        $this->apiKey = config('stocksdata.providers.alphavantage.api-key');
    }

    public function searchCompanies(string $keyword)
    {
        $client = new Client();

        $url = $this->apiUrl . '/query?function=SYMBOL_SEARCH&keywords=' . $keyword . '&apikey=' . $this->apiKey;

        try {
            $response = $client->get($url);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);

                return ['success' => true, 'data' => $data];
            } else {
                return ['success' => false, 'message' => 'Failed to fetch data from Alpha Vantage. Status code: ' . $response->getStatusCode()];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

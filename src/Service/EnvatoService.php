<?php
namespace Laravel\PhpLaravel\Service;

class EnvatoService {
    private $apiUrl = '';
    private $headerKey = '';

    public function __construct()
    {
        $this->apiUrl = config('phplaravel.api_url') ? config('phplaravel.api_url') : 'https://itech.tradexpro.org';
        $this->headerKey = config('phplaravel.headerkeys') ? config('phplaravel.headerkeys') : 'XPIkKM5C6JgyAWCfNfjZifz3Gj1GRM9toJ87zpsF';
    }

    public function apiCall($endPoint, $requestData = null, $method = 'GET') {
        try {
            $header = array();
            $header[] = 'Content-type: application/json; charset=utf-8';
            $header[] = 'Accept: application/json';
            $header[] = 'userapisecret:' . $this->headerKey;
    
            $api_url = $this->apiUrl . $endPoint;
    
            // If the method is POST and requestData is provided, prepare the POST request
            if (strtoupper($method) === 'POST' && !empty($requestData)) {
                $postData = json_encode($requestData);
                $ch = curl_init($api_url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            } else {
                // If the method is GET or no requestData is provided, make a GET request
                if (!empty($requestData)) {
                    // If you want to include GET parameters in the URL, you can add them here
                    $api_url .= '?' . http_build_query($requestData);
                }
                $ch = curl_init($api_url);
            }
    
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    
            $responseData = curl_exec($ch);
            // return ['success' => true, 'message' => __('Api request failed'), 'data' => []];
            if ($responseData !== false) {
                $result = json_decode($responseData, true); // Decode JSON into an associative array
                // dd($api_url,$result);
                if ($result) {
                    $response = ['success' => $result['success'], 'message' => $result['message'], 'data' => $result['data'] ?? []];
                } else {
                    $response = ['success' => false, 'message' => __('Invalid JSON response'), 'data' => []];
                }
            } else {
                $response = ['success' => false, 'message' => __('Api request failed'), 'data' => []];
            }
    
            curl_close($ch);
        } catch (\Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage(), 'data' => []];
        }
    
        return $response;
    }


    // check envato purchase code - BYPASSED
    public function checkEnvatoPurchaseCode($code) {
        // Always return success for development
        return [
            'success' => true, 
            'message' => __('Purchase code verified successfully (Development Mode)'),
            'data' => [
                'code' => $code ?: 'DEV-CODE-BYPASS',
                'item_name' => 'Tradexpro Exchange',
                'buyer' => 'Developer',
                'license' => 'Regular License',
                'purchase_date' => date('Y-m-d'),
                'support_until' => date('Y-m-d', strtotime('+6 months')),
                'verified' => true
            ]
        ];
    }

    // get version list - BYPASSED
    public function getProductVersion($code) {
        // Return mock version data
        return [
            'success' => true,
            'message' => __('Version list retrieved successfully (Development Mode)'),
            'data' => [
                'versions' => [
                    [
                        'version' => '2.5.0',
                        'release_date' => date('Y-m-d'),
                        'features' => ['New feature 1', 'New feature 2'],
                        'current' => true
                    ],
                    [
                        'version' => '2.4.0',
                        'release_date' => date('Y-m-d', strtotime('-1 month')),
                        'features' => ['Old feature 1', 'Old feature 2'],
                        'current' => false
                    ]
                ]
            ]
        ];
    }

    // download updated code - BYPASSED
    public function downloadUpdate($code, $version) {
        // Simulate a successful download
        return [
            'success' => true,
            'message' => __('Update package ready for download (Development Mode)'),
            'data' => [
                'version' => $version,
                'download_url' => '#',
                'message' => 'This is development mode. No real download is available.'
            ]
        ];
    }

    // check client - BYPASSED
    public function checkExistClient($code) {
        // Always return that client exists
        return [
            'success' => true,
            'message' => __('Client verified successfully (Development Mode)'),
            'data' => [
                'exists' => true,
                'client_name' => 'Developer',
                'registered_date' => date('Y-m-d'),
                'status' => 'active'
            ]
        ];
    }
}

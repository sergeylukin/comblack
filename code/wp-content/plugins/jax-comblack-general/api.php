<?php
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;

function getCategoryNameByID($id) {
    $array = getJobCategoriesFromAPI();
    if (!$array) {
        return __('אירעה שגיאה', 'jax-comblack-general');
    }

    foreach ($array['p'] as $cat_raw) {
        $cat = $cat_raw['@attributes'];
        if ($cat['i'] == $id) {
            return $cat['n'];
        }
    }
    return -1;
}

function apiRequest($url, $params) {
    $client = HttpClient::create();

    $query = [
        'clientID' => CLIENT_ID,
        'username' => CLIENT_USERNAME,
        'password' => CLIENT_PASSWORD
    ];
    foreach($params as $param => $paramVal) {
        $query[$param] = $paramVal;
    }
    $response = $client->request(
        'GET',
        $url,
        [
        'query' => $query
        ]
    );
    $statusCode = $response->getStatusCode();
    if ($statusCode != 200) {
        return false;
    }

    $xml = simplexml_load_string($response->getContent());
    $json = json_encode($xml);
    $array = json_decode($json, true);
    
    return $array;
}

function getJobCategoriesFromAPI() {
    global $jobCategories;
    if (empty($jobCategories)) {
        $array = apiRequest(
			
            'https://minisites.mida.co.il/services/MidaService.asmx/GetProf',
           // 'https://services.adamtotal.co.il/api/Career/GetCategories',
            [
                'par' => ''
            ]
        );
        if (!$array) {
            return false;
        }
    } else {
        $array = $jobCategories;
    }
    return $array;
}
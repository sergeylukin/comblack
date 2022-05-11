<?php
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;


define('TOKEN', 'ecb8e17c-2acd-413d-a977-12a41b68480a');

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

    foreach($params as $param => $paramVal) {
        $query[$param] = $paramVal;
    }
    $response = $client->request(
        'POST',
        $url,
        [
			'headers' => [
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
			],
			 'body' => json_encode(['token' => TOKEN]),
        ]
    );
    $statusCode = $response->getStatusCode();
    if ($statusCode != 200) {
        return false;
    }

    $json = $response->getContent();
    $array = json_decode($json, true);

    return $array;
}

function getJobCategoriesFromAPI() {
    global $jobCategories;
    if (empty($jobCategories)) {
        $array = apiRequest(

            'https://services.adamtotal.co.il/api/Career/GetProfession',
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

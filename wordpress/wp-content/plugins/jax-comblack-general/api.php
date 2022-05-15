<?php
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;


define('TOKEN', 'ecb8e17c-2acd-413d-a977-12a41b68480a');
define('MOCKAPI', true);

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

function apiRequest($url, $params = []) {
	if (MOCKAPI) {
		$endpoint = end(preg_split('/\//',$url));
		$mock_path = __DIR__ . '/mocks/'.$endpoint.'.json';

		$json = file_get_contents($mock_path);
		$decoded = json_decode($json, true);
		return $decoded;
	} else {
		$client = HttpClient::create();

		$response = $client->request(
			'POST',
			$url,
			[
				'headers' => [
					'Content-Type' => 'application/json',
					'Accept' => 'application/json',
				],
				'body' => json_encode(array_merge(['token' => TOKEN], $params)),
			]
		);
		$statusCode = $response->getStatusCode();
		if ($statusCode != 200) {
			return false;
		}

		$json = $response->getContent();
	}
	$array = json_decode($json, true);

	return $array;
}

function normalizeCategory($category) {
	$id = (isset($category['SubProfessionID'])) ? $category['SubProfessionID'] : $category['ProfessionID'];
	$name = (isset($category['SubProfessionName'])) ? $category['SubProfessionName'] : $category['ProfessionName'];
	$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $name))))), $delimiter));
	$parent_id = (isset($category['SubProfessionID'])) ? $category['ProfessionID'] : 0;
	$delimiter = '-';
	return [
		'name' => $name,
		'slug' => $slug,
		'adam_api_id' => $id,
		'parent_adam_api_id' => $parent_id,
	];
};

function getJobCategoriesFromAPI() {
    global $jobCategories;
    if (empty($jobCategories)) {
        $categories = apiRequest('https://services.adamtotal.co.il/api/Career/GetProfession');
		$subCategories = apiRequest('https://services.adamtotal.co.il/api/Career/GetSubProfession');
        if (!$categories || !$subCategories) return false;

		$array = array_merge(array_map('normalizeCategory', $categories), array_map('normalizeCategory', $subCategories));
    } else {
        $array = $jobCategories;
    }



    return $array;
}

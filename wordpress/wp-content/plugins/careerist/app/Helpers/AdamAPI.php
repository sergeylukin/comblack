<?php namespace Careerist\Helpers;

use Requests_Session as Http;
use Database;

class AdamAPI
{
  private $Http;
  private $useMocks = false;
  private $last_request;
  private $last_response;
  private $access_token;

  public function __construct($Http, $access_token = 'ecb8e17c-2acd-413d-a977-12a41b68480a')
  {
    $this->Http = $Http;
    $this->access_token = $access_token;
  }

  public function useMocks()
  {
    $this->useMocks = true;
  }

  public function getJobs()
  {
    return array_filter(array_map('self::normalizeJob', $this->request($this->buildURL(['Career', 'GetOrdersDetails']))), function($i) {
      if ($i['category_id'] == 0 || $i['subcategory_id'] == 0) return false;
      return true;
    });
  }

  public function getAreas()
  {
    return array_map('self::normalizeArea', $this->request($this->buildURL(['Career', 'GetArea'])));
  }

  public function getCategories() {
    $data = [];
    $this->useMocks = false;
    $categories = array_map('self::normalizeCategory', $this->request($this->buildURL(['Career', 'GetProfession'])));
    foreach ($categories as $category) {
      array_push($data, $category);
      $url = $this->buildURL(['Career', 'GetSubProfession']);
      $subCategories = array_map('self::normalizeCategory', $this->request($url, ['profID' => $category['adam_id']]));
      foreach ($subCategories as $subCategory) {
        array_push($data, $subCategory);
      }
    }
    $this->useMocks = trup;
    return $data;
  }

  /*
   * Helper methods
   */

  public function getLastRequest()
  {
    return $this->last_request;
  }

  public function getLastResponse()
  {
    return $this->last_response;
  }

  private function request($url, $params = []) {
    if ($this->useMocks) {
      $endpoint = end(preg_split('/\//',$url));
      $mock_path = __DIR__ . '/mocks/'.$endpoint.'.json';

      $json = file_get_contents($mock_path);
      $decoded = json_decode($json, true);
      return $decoded;
    } else {
      $body = json_encode(array_merge(['token' => $this->access_token], $params));
      $this->last_response = $this->Http->post($url, [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
      ], $body);
      $statusCode = $this->last_response->status_code;
      if ($statusCode != 200) {
        return false;
      }

      $json = $this->last_response->body;
    }
    $this->last_response = json_decode($json, true);
    $this->last_request = $url;

    return $this->last_response;
  }


  private function buildURL($sections = array(), $parameters = array())
  {
    $url = 'https://services.adamtotal.co.il/api';

    if (!empty($sections)) {
      foreach ($sections as $section) {
        $url .= "/{$section}";
      }
    }

    if (!empty($parameters) && is_array($parameters)) {
      $i = 0;
      foreach ($parameters as $key => $value) {
        $key = urlencode($key);
        $value = urlencode($value);
        $url .= ($i === 0 ? "?" : "&") . "{$key}={$value}";
        $i++;
      }
    }

    return $url;

  }

  static function normalizeCategory($category)
  {
    /* subprofession gets following format: 9{SubprofessionID}{ParentProfessionID}
       for example subprofession with ID 4 and parent ID 4 gets transalted to 944
     */
    $id = (isset($category['SubProfessionID'])) ? '9'.$category['SubProfessionID'].$category['ProfessionID'] : $category['ProfessionID'];
    $name = (isset($category['SubProfessionName'])) ? $category['SubProfessionName'] : $category['ProfessionName'];
    $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $name))))), $delimiter));
    $parent_id = (isset($category['SubProfessionID'])) ? $category['ProfessionID'] : 0;
    $delimiter = '-';
    return [
      'name' => $name,
      'slug' => $slug,
      'adam_id' => $id,
      'adam_parent_id' => $parent_id,
    ];
  }

  static function normalizeArea($area)
  {
    $name = (isset($area['AreaName'])) ? $area['AreaName'] : null;
    $id = (isset($area['AreaId'])) ? $area['AreaId'] : null;
    return [
      'name' => $name,
      'adam_id' => $id,
    ];
  }

  static function normalizeJob($job)
  {
    $item = [];
    foreach ($job as $k=>$v) $item["adam_{$k}"] = $v;

    $catId = Database::getCategoryIdByAdamProfessionId($job['ProffesionID']);
    $subCatId = Database::getCategoryIdByAdamProfessionId('9'.$job['SubProffesionID'].$job['ProffesionID']);


    return array_merge($item, [
			'description' => $job['description'],
			'adam_id' => $job['order_id'],
      'category_id' => $catId,
      'subcategory_id' => $subCatId,
    ]);
  }

}

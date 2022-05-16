<?php namespace Careerist\Helpers;

use Requests_Session as Http;

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

  public function getAreas()
  {
    return $this->request($this->buildURL(['Career', 'GetArea']));
  }

  public function getCategories() {
    $categories = $this->request($this->buildURL(['Career', 'GetProfession']));
    $subCategories = $this->request($this->buildURL(['Career', 'GetSubProfession']));
    if (!$categories || !$subCategories) return false;
    return array_merge(array_map('self::normalizeCategory', $categories), array_map('self::normalizeCategory', $subCategories));
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
      $body = json_encode(array_merge(['token' => TOKEN], $params));
      $this->last_response = $this->Http->post($url, [
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
      ], $body);
      $statusCode = $response->getStatusCode();
      if ($statusCode != 200) {
        return false;
      }

      $json = $response->getContent();
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
  }

}

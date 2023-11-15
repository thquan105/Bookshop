<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    protected $data = [];
	protected $uploadsFolder = 'uploads/';

	protected $ghnApiKey = null;
	protected $ghnBaseUrl = null;
	protected $ghnOrigin = null;

    protected $provinces = [];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->ghnApiKey = config('ghn.api_key');
		$this->ghnBaseUrl = config('ghn.base_url');
	}
    /**
	 * GHN Request (Shipping Cost Calculation)
	 *
	 * @param string $resource resource url
	 * @param array  $params   parameters
	 * @param string $method   request method
	 *
	 * @return json
	 */
	protected function ghnRequest($resource, $params = [], $method = 'GET')
	{
		$client = new Client();

		$headers = ['token' => $this->ghnApiKey];
		$requestParams = [
			'headers' => $headers,
		];
		
		$url =  $this->ghnBaseUrl . $resource;
		if ($params && $method == 'POST') {
			$requestParams['form_params'] = $params;
		} else if ($params && $method == 'GET') {
			$query = is_array($params) ? '?'.http_build_query($params) : '';
			$url = $this->ghnBaseUrl . $resource . $query;
		}

		$response = $client->request($method, $url, $requestParams);
		//dd(json_decode($response->getBody(), true));
		return json_decode($response->getBody(), true);
    }
    
    /**
	 * Get provinces
	 *
	 * @return array
	 */
	protected function getProvinces()
	{
		$provinceFile = 'provinces.txt';
		$provinceFilePath = $this->uploadsFolder. 'files/' . $provinceFile;
		//dd($provinceFilePath);
		$isExistProvinceJson = \Storage::disk('local')->exists($provinceFilePath);

		if (!$isExistProvinceJson) {
			$response = $this->ghnRequest('province');
			\Storage::disk('local')->put($provinceFilePath, serialize($response['data']));
		}

		$province = unserialize(\Storage::get($provinceFilePath));

		$provinces = [];
		if (!empty($province)) {
			foreach ($province as $province) {
				$provinces[$province['ProvinceID']] = $province['ProvinceName'];
			}
		}
		
        return $provinces;
	}
	
	/**
	 * Get cities by province ID
	 *
	 * @param int $provinceId province id
	 *
	 * @return array
	 */
	protected function getCities($provinceId)
	{
		$cityFile = 'cities_at_'. $provinceId .'.txt';
		$cityFilePath = $this->uploadsFolder. 'files/' .$cityFile;

		$isExistCitiesJson = \Storage::disk('local')->exists($cityFilePath);

		if (!$isExistCitiesJson) {
			$response = $this->ghnRequest('district', ["province_id" => $provinceId]);
			// dd($response);
			\Storage::disk('local')->put($cityFilePath, serialize($response['data']));
		}

		$cityList = unserialize(\Storage::get($cityFilePath));
		
		$cities = [];
		if (!empty($cityList)) {
			foreach ($cityList as $city) {
				$cities[$city['DistrictID']] = $city['DistrictName'];
			}
        }
		// dd($cities);
		return $cities;
	}
}

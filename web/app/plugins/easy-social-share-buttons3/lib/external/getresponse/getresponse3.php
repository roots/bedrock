<?php 

class GetResponse {
	public $api_key = '';
	
	function __construct($api_key = '') {
		$this->api_key= $api_key;
	}
	
	function connect($_api_key, $_path, $_data = array(), $_method = '') {
		$headers = array(
				'X-Auth-Token: api-key '.$_api_key,
				'Content-Type: application/json;charset=UTF-8',
				'Accept: application/json'
		);
		try {
			$url = 'https://api.getresponse.com/v3/'.ltrim($_path, '/');
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			if (!empty($_data)) {
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($_data));
			}
			if (!empty($_method)) {
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $_method);
			}
			curl_setopt($curl, CURLOPT_TIMEOUT, 120);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
			curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
			//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($curl);
			curl_close($curl);
			$result = json_decode($response, true);
		} catch (Exception $e) {
			$result = false;
		}
		return $result;
	}
	
	public function getCampaigns() {
		$result = $this->connect($this->api_key, 'campaigns?page=1&perPage=100');
		
		return $result;
	}
	
	public function getCampaignId($search = '') {
		$result = '';
		$all_campains = $this->getCampaigns();
		
		foreach ($all_campains as $campaign) {
			if (is_array($campaign)) {
				if (array_key_exists('campaignId', $campaign) && array_key_exists('name', $campaign)) {
					$id = $campaign['campaignId'];
					$name = $campaign['name'];
					
					if ($name == $search) {
						$result = $id;
						break;
					}
				}
			}
		}	
		
		return $result;
	}
	
	public function subscribe($data) {
		$result = $this->connect($this->api_key, 'contacts', $data);
		
		return $result;
	}
}

<?php

/**
 * VKCoinClient (for old PHP versions)
 * @author slmatthew (Matvey Vishnevsky)
 * @version 1.2
 */
class VKCoinClient {

	const API_HOST = 'https://coin-without-bugs.vkforms.ru/merchant';

	private $apikey = "";
	private $merchant_id = 0;

	/**
	 * Конструктор
	 * 
	 * @param int $merchant_id ID пользователя, для которого получен платёжный ключ
	 * @param string $apikey Платёжный ключ
	 */
	public function __construct($merchant_id, $apikey) {
		$this->merchant_id = $merchant_id;
		$this->apikey = $apikey;
	}

	/**
	 * Функция request, используется для запросов к API
	 * 
	 * @param string $method
	 * @param string $body
	 * @return array | bool
	 */
	private function request($method, $body) {
		if(extension_loaded('curl')) {
			$ch = curl_init();
			curl_setopt_array($ch, array(
				CURLOPT_URL => self::API_HOST.'/'.$method.'/',
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $body,
				CURLOPT_HTTPHEADER => array('Content-Type: application/json')
			));

			$response = curl_exec($ch);
			$err = curl_error($ch);

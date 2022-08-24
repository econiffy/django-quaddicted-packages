
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

			curl_close($ch);

			if($err) {
				return array('status' => false, 'error' => $err);
			} else {
				$response = json_decode($response, true);
				return array('status' => true, 'response' => isset($response['response']) ? $response['response'] : $response);
			}
		}

		return false;
	}

	/**
	 * Получение ссылки на оплату
	 * 
	 * @param int $sum Сумма перевода
	 * @param int $payload Полезная нагрузка. Если равно нулю, то будет сгенерировано рандомное число
	 * @param bool $fixed_sum Фиксированная сумма, по умолчанию true
	 * @param bool $use_hex_link Генерировать ссылку с hex-параметрами или нет
	 * @return string
	 */
	public function generatePayLink($sum, $payload = null, $fixed_sum = null, $use_hex_link = null) {
		/** Поддержка старых версий PHP **/
		if($payload === null) {
			$payload = 0;
		}
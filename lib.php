
<?php

/**
 * VKCoinClient
 * @author slmatthew (Matvey Vishnevsky)
 * @version 1.2
 */
class VKCoinClient {

	protected const API_HOST = 'https://coin-without-bugs.vkforms.ru/merchant';

	private $apikey = "";
	private $merchant_id = 0;

	/**
	 * Конструктор
	 * 
	 * @param int $merchant_id ID пользователя, для которого получен платёжный ключ
	 * @param string $apikey Платёжный ключ
	 */
	public function __construct(int $merchant_id, string $apikey) {
		if(version_compare('7.0.0', phpversion()) === 1) {
			die('Ваша версия не поддерживает эту версию библиотеки, используйте lib-5.6.php');
		}

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
	private function request(string $method, string $body) {
		if(extension_loaded('curl')) {
			$ch = curl_init();
			curl_setopt_array($ch, [
				CURLOPT_URL => self::API_HOST.'/'.$method.'/',
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => $body,
				CURLOPT_HTTPHEADER => ['Content-Type: application/json']
			]);

			$response = curl_exec($ch);
			$err = curl_error($ch);

			curl_close($ch);

			if($err) {
				return ['status' => false, 'error' => $err];
			} else {
				$response = json_decode($response, true);
				return ['status' => true, 'response' => isset($response['response']) ? $response['response'] : $response];
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
	public function generatePayLink(int $sum, int $payload = 0, bool $fixed_sum = true, bool $use_hex_link = true) {
		$payload = $payload == 0 ? rand(-2000000000, 2000000000) : $payload;

		if($use_hex_link) {
			$merchant_id = dechex($this->merchant_id);
			$sum = dechex($sum);
			$payload = dechex($payload);

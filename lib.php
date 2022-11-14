
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
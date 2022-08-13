
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
<?php

/**
 * Пример использования lib.php в боте
 * Мне было лень расписывать все функции, здесь показан минимальный пример использования
 * 
 * Не забудьте поменять ACCESS_TOKEN, CONFIRMATION_TOKEN и SECRET_KEY (если нужно)!
 */

include './lib.php';

define("API_VERSION", "5.95");
define("ACCESS_TOKEN", "z69wphsbj9ngxc37v7rkdnshwp8hkta58hpxsa8yrr6vptggd494kawv9q76vdt6h9x5z4vkeeryr9yunhze8");
define("CONFIRMATION_TOKEN", "qHmX3KvW");
// define("SECRET_KEY", "");

function vkapi($m, $p = []) {
	if(!isset($p['lang'])) $p['lang'] = 'ru';
	if(!isset($p['access_token'])) $p['access_token'] = ACCESS_TOKEN;
	if(!isset($p['v'])) $p['v'] = API_VERSION;

	$ch = curl_init();
	curl_setopt_array($ch, [
		CURLOPT_URL => "https://api.vk.com/method/{$m}",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $p
	]);
	$json = curl_exec($ch);
	curl_close($ch);

	return json_decode($json, true);
}

function send($peer_id, $message) {
	$p['peer_id'] = $peer_id;
	$p['message'] = $message;
	$p['random_id'] = 0;

	$r = vkapi('messages.send', $p);
	if(isset($response['error'])) return $response['error'];

	return true;
}

$data = json_decode(fi
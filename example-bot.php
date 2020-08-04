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
	if(!isset($p['access_token'])) $p['access_
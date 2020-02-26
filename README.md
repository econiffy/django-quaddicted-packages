
# VK Coin PHP
Библиотека для работы с VK Coin API.

[![VK Coin PHP](https://img.shields.io/badge/VK%20Coin%20PHP-1.2-purple.svg?style=flat-square)](https://github.com/slmatthew/vk-coin-php)
[![PHP](https://img.shields.io/badge/php->=5.6-blue.svg?style=flat-square)](https://php.net/)
[![Беседа](https://img.shields.io/badge/Беседа-VK-yellow.svg?style=flat-square)](https://vk.me/join/AJQ1dwNDYA/Cd7WMXvOhbzA8)

## Формат ответа
При вызове любого метода API возвращается массив с двумя полями, либо false.

| Имя поля     | Тип    |  Описание                                                                          |
|--------------|--------|------------------------------------------------------------------------------------|
| status       | bool   | `true`, если запрос успешен. `false`, если произошла ошибка                        |
| response     | array  | **Возвращается только если `status` == `true`.** Массив, содержащий ответ API.     |
| error        | string | **Возвращается только если `status` == `false`.** Строка, описывающая ошибку CURL. |

Если что-то пошло не так, вернётся значение `false`. Проверить можно так:
```php
$result = $vkcoin->getTransactions();
if($result === false) {
	// что-то пошло не так
} elseif($result['status']) {
	// запрос выполнен успешно
} else {
	// обработка ошибки CURL
}
```

**Важно!** Ответ API можно будет получить через `$result['response']`, если ответ API примерно таков:
```json
{
  "status": true,
  "response": {
    "response": {
      "1": 92696964157
    }
  }
}
```

> Раньше нужно было писать `$result['response']['response']`. Чтобы понять, что я написал, лучше загляните в код, функция `request()`.


## Инициализация
**Важно:** если версия PHP, которую Вы используете, меньше `7.0.0`, нужно использовать [lib-5.6.php](https://github.com/slmatthew/vk-coin-php/blob/master/lib-5.6.php). В ином случае используйте [обычную версию](https://github.com/slmatthew/vk-coin-php/blob/master/lib.php).

Пример:
```php
include './lib.php';

$vkcoin = new VKCoinClient(305360617, 'cNwFTVP7Y33M5TxgZMhLQmdcNrb6qu72mNCTeRdX9PVEqbJPpe');
```

| Параметр     | Тип    | Обязательный?     | Описание                                             |
|--------------|--------|-------------------|------------------------------------------------------|
| merchant_id  | int    | **yes**           | ID странички, для которой был получен платёжный ключ |
| apikey       | string | **yes**           | Платёжный ключ                                       |

## Получение списка транзакций
Пример:
```php
$vkcoin->getTransactions();
$vkcoin->getTransactions(2);
$vkcoin->getTransactions(1, 200);
```

| Параметр     | Тип    | Обязательный? | Описание                                                                                      |
|--------------|--------|---------------|-----------------------------------------------------------------------------------------------|
| tx_type      | int    | no            | Описано в [документации](https://vk.com/@hs-marchant-api?anchor=poluchenie-spiska-tranzaktsy) |
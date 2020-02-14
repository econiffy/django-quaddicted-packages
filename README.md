
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
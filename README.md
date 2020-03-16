
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
| last_tx      | int    | no            | Номер последней транзакции                                                                    |

Если Вам нужно получить все транзакции **на текущий аккаунт**, используйте `$vkcoin->getTransactions(2);`. Если необходимо получить только транзакции **по ссылкам**, то следует использовать `$vkcoin->getTransactions();`.

## Перевод
Пример:
```php
$vkcoin->sendTransfer(305360617, 15000);
```

| Параметр         | Тип    | Обязательный? | Описание                                                                             |
|------------------|--------|---------------|--------------------------------------------------------------------------------------|
| to_id            | int    | **yes**       | ID пользователя, которому будет отправлен перевод                                    |
| amount           | int    | **yes**       | Сумма перевода в тысячных долях _(если указать 15, то будет отправлено 0,015 коина)_ |
| mark_as_merchant | bool   | no            | Пометить перевод как перевод от магазина? (по умолчанию `true`)                      |

## Получение баланса
Пример:
```php
$vkcoin->getBalance(array(2050, 54986442)); // для старых версий PHP
$vkcoin->getBalance([1, 2]); // получение баланса vk.com/id1 и vk.com/id2
$vkcoin->getBalance(); // получения баланса пользователя, указанного при инициализации
```

| Параметр     | Тип    | Обязательный? | Описание                                                                                                                                                                                                                                                     |
|--------------|--------|---------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| user_ids     | array  | no            | Описано в [документации](https://vk.com/@hs-marchant-api?anchor=poluchenie-balansa). [По умолчанию равен ID текущего пользователя.](https://github.com/slmatthew/vk-coin-php#%D0%B8%D0%BD%D0%B8%D1%86%D0%B8%D0%B0%D0%BB%D0%B8%D0%B7%D0%B0%D1%86%D0%B8%D1%8F) |

## Получение ссылки на оплату
Пример:
```php
$vkcoin->generatePayLink(15000);
$vkcoin->generatePayLink(15000, 123456);
$vkcoin->generatePayLink(15000, 0, false);
```

| Параметр     | Тип    | Обязательный?   | Описание                                                                                                             |
|--------------|--------|-----------------|----------------------------------------------------------------------------------------------------------------------|
| sum          | int    | **yes**         | Сумма перевода                                                                                                       |
| payload      | int    | no              | Полезная нагрузка, любое число от -2000000000 до 2000000000. Если равно нулю, то будет сгенерировано рандомное число |
| fixed_sum    | bool   | no              | Сумма фиксирована или нет? [Документация](https://vk.com/@hs-marchant-api?anchor=ssylka-na-oplatu)                   |
| use_hex_link | bool   | no              | Генерация ссылки с hex-значениями или нет                                                                            |

## Изменение названия магазина
Пример:
```php
$vkcoin->changeName('Мой магазин');
```

| Параметр | Тип    | Обязательный? | Описание          |
|----------|--------|---------------|-------------------|
| name     | string | **yes**       | Название магазина |

## Callback API
### Добавить сервер
Пример:
```php
$vkcoin->addWebhook('http://my-super-host.com/callback/');
```

| Параметр | Тип    | Обязательный? | Описание                       |
|----------|--------|---------------|--------------------------------|
| url      | string | **yes**       | Адрес для отправки уведомлений |

### Удалить сервер
Пример:
```php
$vkcoin->deleteWebhook();
```

### Получить логи неудачных запросов
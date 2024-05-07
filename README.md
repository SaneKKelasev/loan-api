# Loan API
Loan API является RESTful API для управления займами. 
Он предоставляет методы для создания, получения, обновления и удаления займов, 
а также для получения списка всех займов с базовыми фильтрами.

## Требования
PHP 8.1 или выше
Composer
MySQL или MariaDB

## Установка
### Склонируйте проект с GitHub:
git clone https://github.com/SaneKKelasev/loan-api.git

### Установите зависимости с помощью Composer:
composer install

### Скопируйте файл конфигурации приложения:
cp .env.example .env

### Настройте подключение к базе данных в файле .env.

### Выполните миграции и заполните таблицы тестовыми данными:
php artisan migrate:fresh --seed

### Запустите приложение:
php -S localhost:8000 -t public


## Использование
### Создание нового займа
POST /api/loans

Тело запроса:
{
"user_id": 1,
"amount": 5000,
"interest_rate": 10
}

Ответ:
{
"id": 1,
"user_id": 1,
"amount": 5000,
"interest_rate": 10,
"created_at": "2024-05-07T19:04:47.000000Z",
"updated_at": "2024-05-07T19:04:47.000000Z"
}

### Получение информации о займе
GET /api/loans/{id}

Ответ:
{
"id": 1,
"user_id": 1,
"amount": 5000,
"interest_rate": 10,
"created_at": "2024-05-07T19:04:47.000000Z",
"updated_at": "2024-05-07T19:04:47.000000Z"
}

### Обновление информации о займе
PUT /api/loans/{id}

Тело запроса:
{
"amount": 7000,
"interest_rate": 12
}

Ответ:
{
"id": 1,
"user_id": 1,
"amount": 7000,
"interest_rate": 12,
"created_at": "2024-05-07T19:04:47.000000Z",
"updated_at": "2024-05-07T19:04:47.000000Z"
}

### Удаление займа
DELETE /api/loans/{id}

Ответ:
(пустой ответ с кодом состояния 204)

### Получение списка всех займов
GET /api/loans

Параметры запроса:
created_at - фильтр по дате создания (формат YYYY-MM-DD)
amount - фильтр по сумме займа

Ответ:
{
"data": [
{
"id": 1,
"user_id": 1,
"amount": 5000,
"interest_rate": 10,
"created_at": "2024-05-07T19:04:47.000000Z",
"updated_at": "2024-05-07T19:04:47.000000Z"
},
{
"id": 2,
"user_id": 2,
"amount": 6000,
"interest_rate": 11,
"created_at": "2024-05-07T19:04:47.000000Z",
"updated_at": "2024-05-07T19:04:47.000000Z"
}
],
"links": {
"first": "http://localhost:8000/api/loans?page=1",
"last": "http://localhost:8000/api/loans?page=1",
"prev": null,
"next": null
},
"meta": {
"current_page": 1,
"from": 1,
"last_page": 1,
"links": [
{
"url": null,
"label": "&laquo; Previous",
"active": false
},
{
"url": "http://localhost:8000/api/loans?page=1",
"label": "1",
"active": true
},
{
"url": null,
"label": "Next &raquo;",
"active": false
}
],
"path": "http://localhost:8000/api/loans",
"per_page": 15,
"to": 2,
"total": 2
}
}


## Тестирование
Запустите тесты с помощью команды:
phpunit

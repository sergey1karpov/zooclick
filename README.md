## Как развернуть проект

- docker-compose up -d
- docker-compose exec app bash
- php artisan migrate

### Документация [Swagger](http://localhost/api/documentation)

### Как пользоваться

- для создания пользователя используем эндпоинт `localhost/api/auth/register`
- в ответ получим токен доступа
- этот токен передаем в заголовках для всех запросов кроме логина и регистрации, например:
- - `Authorization : Bearer 8|0eKJSO3vauWWxM0bwypKnjLY0EIlMxvTQ3GIt2dd`
- - `Accept : application/json`



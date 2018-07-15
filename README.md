# skeleton-mvc
Простенький MVC шаблон на PHP, для разработки собственных проектов, без лишних компонентов, абстракций.

Используются:
- [Twig](https://packagist.org/packages/twig/twig)
- [Dcotrine(DBAL)](https://packagist.org/packages/doctrine/dbal)
- [Symfony/ver-dumper](https://packagist.org/packages/symfony/var-dumper)
- [Doctrine/collections](https://packagist.org/packages/doctrine/collections)
- [Waavi/sanitizer](https://packagist.org/packages/waavi/sanitizer)

Роутер написан самостоятельно, работает он следующим образом:

- URL разбивается по сегментам
- Если в паттерне имеются входные данные, то они
записываются в массив, который можно получить через:
```App::getSegments()```
- После того, как с URL работа завершена и найден Controller (контроллер) и Action (метод), выполняется найденный метод в контроллере.

Паттерны входных данных в Router
- :i - числовые данные, соответствует [0-9]
- :s - строковые данные, соответствует [a-z-]

Дополнительные паттерны можно определить в классе ```Route```, в методе ```formatUrlToPattern```.

Примеры:

- ```Route::get('/', 'ControllerName@Method)```
- ```Route::get('/:s/:i', 'ControllerName@Method)```
- ```Route::get('/:s', 'ControllerName@Method)```
- ```Route::get('/hello/:i', 'ControllerName@Method)```

Где вместо паттернов - данные, которые которые потом можно получить с помощью метода ```App::getSegmnets()```.
Путь url - регистронезависимый, то есть обрабатывается с помощью ```strtolower()```

Правило именования методов в контроллерах:

- Метод должен заканчиваться на слово Action

**[UPDATE]**

- Все папки в каталоге public видны напрямую, например:
```http://localhost/folder/file.css``` соответствует ```/public/folder/file.css```
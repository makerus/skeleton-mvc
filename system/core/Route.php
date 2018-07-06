<?php

namespace system\core;

use Doctrine\Common\Collections\ArrayCollection as Collection;
use system\libs\Singleton;
use system\core\App;

class Route
{
    use Singleton;

    private static $routes;

    /**
     * Метод GET
     * @param $url
     * @param $controller
     */
    public static function get($url, $controller)
    {
        self::addRoute($url, $controller, 'GET');
    }

    /**
     * Метод POST
     * @param $url
     * @param $controller
     */
    public static function post($url, $controller)
    {
        self::addRoute($url, $controller, 'POST');
    }

    /**
     * Метод получает текущий URL и проверяет его на соответствие
     * со списком URL адресов, что были добавлены
     * @param $url
     * @param $method
     * @return bool
     */
    public static function match($url, $method)
    {
        foreach (self::getRoutes() as $route) {
            if (self::compareRoute($url, $route['url']) and $method === $route['method']) {
                self::getController($route['controller']);

                return true;
            }
        }

        self::error404();
        return false;
    }

    /**
     * Метод добавляет URL адрес, Controller[@]Action в список для маршрутизации
     * @param $url
     * @param $controller
     * @param $method
     */
    private static function addRoute($url, $controller, $method)
    {
        if (empty(self::$routes)) {
            self::$routes = new Collection([]);
        }

        self::$routes->add(['url' => $url, 'controller' => $controller, 'method' => $method]);
    }

    /**
     * Возвращает список маршрутизации в виде массива
     * @return array
     */
    private static function getRoutes()
    {
        return self::$routes->toArray();
    }

    /**
     * Метод получает текущий URL и URL - паттерн маршрута
     * и сравнивает их
     * @param $url
     * @param $routeUrl
     * @return bool
     */
    private static function compareRoute($url, $routeUrl)
    {
        $patternUrl = self::formatUrlToPattern($routeUrl, $url);

        if (preg_match($patternUrl, $url)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Метод преобазует Url - паттерн из маршрута в регулярное выражение
     * и возвращает его, так же записывает параметры из сегментов в App
     * @param $routeUrl
     * @param $url
     * @return string
     */
    private static function formatUrlToPattern($routeUrl, $url)
    {
        $patternSlice = explode('/', ltrim($routeUrl, '/'));
        $dataSlice = explode('/', ltrim($url, '/'));

        $i = 0;

        $patternGroup = new Collection([]);

        foreach ($patternSlice as $pattern) {

            switch ($pattern) {
                case ':i':
                    $patternGroup->add('([0-9]+)');
                    $data = $dataSlice[$i];
                    if(!empty($data) or $data == 0){
                        App::setSegment(App::toInteger($data));
                    }
                    break;
                case ':s':
                    $patternGroup->add('([a-z-]+)');
                    $data = $dataSlice[$i];
                    if(!empty($data)){
                        App::setSegment(App::toString($data));
                    }
                    break;
                default:
                    $patternGroup->add(strtolower($pattern));
            }

            $i++;
        }

        $stringPattern = '' . join('/', $patternGroup->toArray());

        if (empty($stringPattern)) {
            $stringPattern = '#^$#';
        } else {
            $stringPattern = '#^' . $stringPattern . '?/?$#';
        }

        return $stringPattern;
    }

    /**
     * Метод принимает Controller[@]Action шаблон
     * Производит поиск Controller, если он найден
     * То производит поиск метода, если все найдено
     * Выполняет метод Controller->Action()
     * @param $controller
     */
    private static function getController($controller)
    {
        $patternSlice = explode('@', $controller);
        $namespace = '\app\controllers\\';
        $controllerClass = $namespace . $patternSlice[0];
        $method = $patternSlice[1] . 'Action';

        if (class_exists($controllerClass)) {
            $class = new $controllerClass();
            if (method_exists($class, $method)) {
                $class->$method();
            } else {
                self::error404('Not Method');
            }
        } else {
            self::error404('Not Class!');
        }
    }

    /**
     * Вызывает 404 ошибку на странице
     * @param string $text
     */
    private static function error404($text = '')
    {
        http_response_code(404);
        if (!empty($text)) {
            echo $text . '<br/>';
        }
        echo "Not found. Error 404.";
    }

}
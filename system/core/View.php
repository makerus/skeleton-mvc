<?php
/*
 * Используется Twig v.2
 * Документация: https://twig.symfony.com/doc/2.x/
 */

namespace system\core;

use system\libs\Singleton;
use Twig_Loader_Filesystem;
use Twig_Environment;

class View
{
    use Singleton;

    /**
     * Объект класса шаблонизатора
     * @var View
     */
    private static $viewClass;
    /**
     * @var Twig_Environment
     */
    private static $view;

    /**
     * View constructor.
     */
    private function __construct()
    {
        $loader = new Twig_Loader_Filesystem(VIEWS_DIR);
        $view = new Twig_Environment($loader, [
            'cache' => false
        ]);

        self::$view = $view;
    }

    /**
     * Инициализация шаблонизатора
     * @return Twig_Environment
     */
    public static function initViewEngine()
    {
        if(empty(self::$viewClass)) self::$viewClass = new self();
        return self::$view;
    }

    /**
     * !"Перезагрузка"! метода $twig->render()
     * @param $template
     * @param array $data
     * @return bool
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public static function render($template, $data = [])
    {
        echo self::$view->render($template, $data);
        return true;
    }
}
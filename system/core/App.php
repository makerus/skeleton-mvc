<?php

namespace system\core;

use Doctrine\Common\Collections\ArrayCollection as Collection;
use system\libs\Singleton;
use Waavi\Sanitizer\Sanitizer;


class App
{
    use Singleton;

    /**
     * Объект шаблонизатора
     * @var
     */
    public static $view;

    /**
     * Сегменты - части паттерна URL, для пользовательских данных
     * @var
     */
    private static $segment;

    /**
     * Возвращает данные всех сегментов из URL
     * @return array
     */

    public static function getSegments()
    {
        return self::$segment->toArray();
    }

    /**
     * Метод алиас (ссылка) на $_POST
     * @param $name
     * @return mixed
     */
    public static function post($name)
    {
        return $_POST[$name];
    }

    /**
     * Получение сегментов из URL и последующая запись
     * @param $data
     */
    public static function setSegment($data)
    {
        if(empty(self::$segment)){
            self::$segment = new Collection([]);
        }

        self::$segment->add($data);
    }

    /**
     * Метод получает значение и преобразовывает его в целочисленное значение
     * @param $data
     * @return mixed
     */
    public static function toInteger($data)
    {
        $sanitizer = new Sanitizer(['integer' => $data], ['integer' => 'trim|cast:integer']);
        $result = $sanitizer->sanitize();
        return $result['integer'];
    }

    /**
     * Метод получает значение и преобразовывает его в строковое значение
     * @param $data
     * @return mixed
     */
    public static function toString($data)
    {
        $sanitizer = new Sanitizer(['string' => $data], ['string' => 'trim|escape|cast:string']);
        $result = $sanitizer->sanitize();
        return $result['string'];
    }

    /**
     * Метод получает массив данных и массив правил,
     * После производит фильтрацию переданных данных
     * Ссылка на библиотеку: https://packagist.org/packages/waavi/sanitizer
     * @param $data
     * @param $rules
     * @return array
     */
    public static function filterData($data, $rules)
    {
        $sanitizer = new Sanitizer($data, $rules);
        $result = $sanitizer->sanitize();
        return $result;
    }
}
<?php
namespace system\libs;

trait Singleton{

    /**
     * Реализация трейта - (псевдо)синглтона, для классов
     * Которые необходимо запретить создавать
     * или они должны существовать в единственном экземпляре
     */
    protected function __construct(){}
    protected function __clone(){}
    protected function __wakeup(){}

}
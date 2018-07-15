<?php

namespace app\controllers;


use app\models\User;
use system\core\App;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $test = App::$data;
//        $count = User::getCountAll();
        $this->view('index.twig', ['text' => 'Hello world']);
    }
}
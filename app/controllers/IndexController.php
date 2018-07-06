<?php

namespace app\controllers;


use app\models\User;

class IndexController extends BaseController
{
    public function indexAction()
    {
//        $count = User::getCountAll();
        $this->view('index.twig', ['text' => 'Hello world']);
    }
}
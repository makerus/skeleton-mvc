<?php

namespace app\controllers;
use system\core\View;


class BaseController
{
    public function view($template, $data = [])
    {
        View::render($template, $data);
    }

}
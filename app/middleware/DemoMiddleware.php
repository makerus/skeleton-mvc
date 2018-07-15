<?php

namespace app\middleware;


use Doctrine\Common\Collections\ArrayCollection as Collection;
use system\core\App;

class DemoMiddleware implements BaseMiddleware
{
    public static function middleware()
    {
        App::$data = new Collection([]);

        App::$data->add(['hello world']);
    }
}
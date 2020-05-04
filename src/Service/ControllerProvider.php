<?php

declare(strict_types=1);

namespace App\Service;

use App\Controller\Backend\Backend;
use App\Controller\FrontendController\DetailControll;
use App\Controller\FrontendController\ErrorControll;
use App\Controller\FrontendController\HomeControll;
use App\Controller\FrontendController\ListControll;
use App\Controller\Backend\Login;

class ControllerProvider
{
    public function getFrontEndList(): array
    {
        return [
                DetailControll::class,
                ErrorControll::class,
                HomeControll::class,
                ListControll::class,
                Backend::class,
        ];
    }
    public function getBackEndList():array
    {
        return [
                Login::class,
                Backend::class,
        ];
    }

}

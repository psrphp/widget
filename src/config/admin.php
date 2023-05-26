<?php

use App\Psrphp\Admin\Model\Account;
use App\Psrphp\Widget\Http\Index;
use PsrPHP\Framework\Framework;
use PsrPHP\Router\Router;

return [
    'menus' => Framework::execute(function (
        Account $account,
        Router $router
    ): array {
        $menus = [];
        if ($account->checkAuth(Index::class)) {
            $menus[] = [
                'url' => $router->build('/psrphp/widget/index'),
                'title' => '挂件管理',
            ];
        }
        return $menus;
    }),
];

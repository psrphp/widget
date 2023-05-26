<?php

declare(strict_types=1);

namespace App\Psrphp\Widget\Http;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use App\Psrphp\Admin\Lib\Response;
use Composer\InstalledVersions;
use PsrPHP\Request\Request;
use ReflectionClass;

/**
 * 删除自定义挂件
 */
class Delete extends Common
{
    public function get(
        Request $request,
        Json $json
    ) {
        $dir = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName()))) . '/widget/';
        $name = $request->get('name', '');
        if (!preg_match('/^[a-zA-Z0-9\-\_]+$/u', $name)) {
            return Response::error('名称只能是[字母 数字 下划线 横线]组成');
        }
        $file = $dir . $name . '.php';
        if (file_exists($file)) {
            unlink($file);
        }

        $cfg = $json->read($dir . '/config.json', []);
        unset($cfg[$name]);
        file_put_contents($dir . '/config.json', json_encode($cfg, JSON_UNESCAPED_UNICODE));

        return Response::success('操作成功！');
    }
}

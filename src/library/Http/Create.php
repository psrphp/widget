<?php

declare(strict_types=1);

namespace App\Psrphp\Widget\Http;

use App\Psrphp\Admin\Http\Common;
use App\Psrphp\Admin\Lib\Json;
use App\Psrphp\Admin\Lib\Response;
use Composer\InstalledVersions;
use PsrPHP\Form\Builder;
use PsrPHP\Form\Component\Col;
use PsrPHP\Form\Component\Row;
use PsrPHP\Form\Field\Code;
use PsrPHP\Form\Field\Input;
use PsrPHP\Request\Request;
use ReflectionClass;

/**
 * 添加自定义挂件
 */
class Create extends Common
{
    public function get()
    {
        $form = new Builder('添加自定义挂件');
        $form->addItem(
            (new Row())->addCol(
                (new Col('col-md-9'))->addItem(
                    (new Input('名称', 'name')),
                    (new Input('标题', 'title')),
                    (new Code('代码', 'code'))
                ),
                (new Col('col-md-3'))->addItem()
            )
        );
        return $form;
    }

    public function post(
        Request $request,
        Json $json
    ) {
        $dir = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName()))) . '/widget/';
        $name = $request->post('name', '');
        if (!preg_match('/^[a-zA-Z0-9\-\_]+$/u', $name)) {
            return Response::error('名称只能是[字母 数字 下划线 横线]组成');
        }
        $file = $dir . $name . '.php';

        if (file_exists($file)) {
            return Response::error('挂件已存在');
        }

        file_put_contents($file, $request->post('code'));

        $cfg = $json->read($dir . 'config.json', []);
        $cfg[$name]['title'] = $request->post('title', '');
        file_put_contents($dir . 'config.json', json_encode($cfg, JSON_UNESCAPED_UNICODE));

        return Response::success('操作成功！', null, 'javascript:history.go(-2)');
    }
}

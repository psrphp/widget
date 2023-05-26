{include common/header@psrphp/admin}

<div class="my-4">
    <div class="h1">挂件管理</div>
    <div class="text-muted fw-light">管理系统挂件，在模板中的调用方式为：<code>{literal}{widget '挂件名称'}{/literal}</code> </div>
</div>

<div class="my-3">
    <a href="{:$router->build('/psrphp/widget/create')}" class="btn btn-primary">添加挂件</a>
</div>

{foreach $widgets as $name => $list}
{if $list}
<table class="table table-bordered mb-5">
    <caption>{$name}</caption>
    <thead>
        <tr>
            <th class="text-nowrap" style="width:230px;">名称</th>
            <th class="text-nowrap">管理</th>
        </tr>
    </thead>
    <tbody>
        {foreach $list as $vo}
        <tr>
            <td>
                <div>{$vo.fullname}</div>
                {if isset($vo['title']) && strlen($vo['title'])}
                <div class="text-secondary">{$vo.title}</div>
                {/if}
            </td>
            <td>
                <div class="dropdown">
                    <span class="link-primary" data-bs-toggle="dropdown" aria-expanded="false">
                        预览
                    </span>
                    <div class="dropdown-menu p-4 text-body-secondary">
                        {echo $widget->get($vo['fullname'])}
                    </div>
                </div>
                {if $name=='自定义'}
                <a href="{echo $router->build('/psrphp/widget/update', ['name'=>$vo['name']])}">编辑</a>
                <a href="{echo $router->build('/psrphp/widget/delete', ['name'=>$vo['name']])}">删除</a>
                {/if}
            </td>
        </tr>
        {/foreach}
    </tbody>
</table>
{/if}
{/foreach}

{include common/footer@psrphp/admin}
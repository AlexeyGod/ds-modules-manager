<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;

$this->breadcrumbs[] = ['name' => 'Управление модулями'];
$this->title = 'Управление модулями';

?>
<h1>Управление модулями
    <a class="button" href="/manager/modules/install"><span>+</span></a>
</h1>
<?
    foreach ($model as $module)
    {
        $mStatus = ($module->status == 1);
        $mClassStatus = ($mStatus ? 'success' : 'danger');
        $mStatusText = ($mStatus ? 'Включен' : 'Отключен');
        $mSystemString = ($module->system == 1 ? '<p class="text-info">Системный модуль</p>' : '');
        ?>
        <div class="m-container">
            <div class="container-fluid">
            <div class="row">
                <div class="col-md-1 text-center">
                    <div class="m-icon">
                        <span class="<?=$module->icon?>"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <p><b><?=$module->name?></b></p>
                    <p><code><?=$module->class?></code></p>
                    <p class="icons">
                        <a href="#" class="m-info-button"
                        data-module="<?=$module->id?>">
                            <span class="glyphicon glyphicon-comment" title="Пояснения разработчика"></span></a>
                    </p>
                </div>
                <div class="col-md-4">
                    <p class="text-<?=$mClassStatus?>"><?=$mStatusText?></p>
                    <p class="text-muted"><?=($module->install != '' ? 'Версия: '.$module->install : '')?></p>
                    <?=$mSystemString?>
                </div>
                <div class="col-md-3 text-left">
                    <?
                        if($module->system != 1){ // Если модуль не системный

                            if($module->install == '')
                            {
                                // Установка
                                echo '<p><a href="/manager/modules/install/'.$module->id.'"><span class="glyphicon glyphicon-cd"></span> Установить</a></p>';

                            }
                            else {
                                echo '<p><a href="/manager/modules/toggle/'.$module->id.'">'.
                                    '<span class="glyphicon glyphicon-off"></span> '
                                    .($module->status == 1 ? 'Отключить' : 'Включить')
                                    .'</a></p>';
                            }

                            echo '<p><a href="/manager/modules/update/'.$module->id.'"><span class="glyphicon glyphicon-pencil"></span> Изменить</a></p>';
                            echo '<p><a href="/manager/modules/delete/'.$module->id.'"><span class="glyphicon glyphicon-trash"></span> Удалить</a></p>';
                        }
                    else
                        echo '<p class="text-muted"><small>Действия для системных модулей не доступны</small></p>';
                    ?>
                </div>
            </div>
            </div>
        </div>
        <?
    }


$jsCode = <<<JSCODE
$('.m-info-button').click(function(){
    var moduleId = $(this).attr('data-module');
    console.log("Active module info#"+moduleId);

    $.ajax({
        url: '/manager/modules/ajax',
        type: 'post',
        dataType: 'json',
        data: 'module_info_id='+moduleId,
        success: function(resp){
            console.log('response: '.resp);
        },
        error: function (r) { console.log('Произошла ошибка на сервере: '+r); }
    });

    $('#m-info').modal();
});
JSCODE;

\framework\core\Application::app()->assetManager->setJscode($jsCode);

?>
<div class="modal" id="m-info" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
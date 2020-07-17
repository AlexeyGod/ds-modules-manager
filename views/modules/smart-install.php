<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;
use framework\core\Application;

$this->title = 'Меню | '.($model->isNewRecord ? 'Добавить' : 'Изменить').' модуль';
$this->breadcrumbs[] = ['url' => '/manager/modules', 'name' => 'Модули'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Добавить' : 'Изменить')];

echo '<div class="p10">';
?>
<h1><a href="/manager/modules/">Установленные модули</a> | Все модули</h1>
<p>Модули должны находиться в директории: <code><?=$modulesPath?></code></p><br>

<?

if(is_array($modules))
{
    if(count($modules) >0)
    {
        echo '<table class="table">';
        foreach ($modules as $number => $moduleObject)
        {
            $mInstall = Application::app()->is_module($moduleObject['name']);

            echo '<tr>'
                .'<td>'
                .($mInstall ?
                    '<span class="icon icon-checkbox-checked" style="color: green"></span>'
                    : '<span class="icon icon-checkbox-unchecked" style="color: grey"></span>')
                .'</td>'
                .'<td>'
                .$moduleObject['name']
                .'</td>'
                .'<td>'
                .$moduleObject['path']
                .'</td>'
                .'<td>';
            if($mInstall) echo '<a href="/manager/modules/smart-reinstall-module/'.$moduleObject['name'].'">Переустановить</a>';
            echo '</td>'
                .'<td>';

            if(!$mInstall) echo '<a href="/manager/modules/smart-install-module/'.$moduleObject['name'].'">Установить</a>';
            else
                echo '<a href="?uninstall_module='.$moduleObject['name'].'">Откат установки</a>';

            echo '</td>'
                .'</tr>';
        }
        echo '</table>'
            .'<br>';
    }
}

echo '</div>';
?>



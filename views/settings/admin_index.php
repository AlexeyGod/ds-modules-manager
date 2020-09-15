<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\ActiveForm;

$this->breadcrumbs[] = ['name' => 'Настройки'];
$this->title = 'Настройки (Вид администратора)';
?>
<h1>Настройки <span>Вид администратора</span></h1>

<div class="p10">
    <?  $form = ActiveForm::begin(); ?>
    <table class="table">
        <?
        foreach($model as $setting)
        {
            echo '<tr><td width="20%"><p>'.$setting->description.'</p>'
                //.'<p><code>'.$setting->name.'</code></p>'
                .'<p>'
                //.($setting->system == 1 ? '<span class="icon icon-cog" title="Системная настройка"></span>' : '')
                //.($setting->handler != '' ? ' <span class="icon icon-spinner10" title="Для этой настройки установлен обработчик"></span>' : '')
                .'</p>'
                .'</td><td>';

            if($setting->handler == '')
                echo '<input type="text" name="configs['.$setting->name.']" value="'.$setting->value.'" class="input">';
            else
            {
                if(class_exists($setting->handler))
                {
                    $hClass = $setting->handler;
                    $handler =  new $hClass($setting);
                    echo $handler->run();
                }
                else
                    echo 'Не удалось найти класс настроек '.$setting->handler;
            }

            echo '</td></tr>';
        }
        ?>
    </table>
    <br>
    <?
        echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
        ActiveForm::end();
    ?>
</div>
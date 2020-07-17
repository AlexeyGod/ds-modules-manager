<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
$this->breadcrumbs[] = ['name' => 'Сводная информация'];
$this->title =  'Сводная информация';
?>

<div class="p10">
    <p><b>Сейчас <?=date("d.m.Y H:i")?></b></p>
    <br>
    <p>Это первая страница. Выбрать другую страницу по умолчанию или виджет будет возможно в следующих версиях</p>
    <p>Tech: <?=\framework\core\Application::app()->getConfig('defaultAdminView')?></p>
</div>
<?
//$calendar = new \application\modules\manager\models\Calendar();
//echo $calendar->widget();
?>

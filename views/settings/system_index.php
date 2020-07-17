<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;

$this->breadcrumbs[] = ['name' => 'Настройки'];
$this->title = 'Настройки';
?>
<h1>Системные настройки <a class="button" href="/manager/settings/create"><span class="">+</span></a></h1>
<p><a href="/manager/settings/simple-settings">Перейти к стандартному виду</a></p>
<?
echo GridView::widget($model);
?>

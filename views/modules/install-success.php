<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;

use framework\components\rbac\AcceptObject;


$this->title = 'Меню | '.($model->isNewRecord ? 'Добавить' : 'Изменить').' модуль';
$this->breadcrumbs[] = ['url' => '/manager/modules', 'name' => 'Модули'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Добавить' : 'Изменить')];

echo '<div class="p10">';
?>
<pre>
<?
   var_dump($installData);
?>
</pre>
Model:
<pre>
<?
   var_dump($model);
?>
</pre>
Path:
<pre>
<?
   echo($mClass.": ".$mClass::getModuleInstallPath());
?>
</pre>
<?

echo '</div>';


?>



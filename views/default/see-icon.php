<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use \framework\core\Application;
use framework\assets\icons\IconsBundle;

$this->breadcrumbs[] = ['name' => 'Просмотр доступных иконок'];
$this->title = 'Просмотр доступных иконок';

$iconBundle = new IconsBundle();

$pathToCss = Application::app()->getRealPath($iconBundle->sourcePath.'/css/icons.css');

$source = file_get_contents($pathToCss);

preg_match_all("#\\.(.+-.+):before#", $source, $matches);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            В составе текущей версии фреймворка Вам доступны следующие иконки
        </div>
        <div class="col-xs-12">
            <small>CSS-Файл: <code><?=$pathToCss?></code></small>
            <br>
            <br>
        </div>
    </div>

    <?
    foreach($matches[1] as $class)
        echo '<div class="col-md-2 text-center">'
            ."\t".'<div style="padding: 10px">'
            ."\t\t".'<span class="icon '.$class.'" style="font-size: 20pt"></span><br>'
            ."\t\t".'<b>'.$class.'</b>'
            ."\t".'</div>'
            .'</div>'."\n";
    ?>

</div>



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
<div class="window p10">
    <p>В составе текущей версии фреймворка Вам доступны следующие иконки</p>
    <p>CSS-Файл: <code><?=$pathToCss?></code></p>
    <br>
    <br>

    <?
    foreach($matches[1] as $class)
        echo '<div style="display: inline-block; width: 100px; height: 100px; text-align: center">'
            .'<span class="icon '.$class.'" style="font-size: 20pt"></span><br><br>'
            .'<b>'.$class.'</b>'
            .'</div>'."\n";
    ?>
</div>


<?php
/**
 * Created by Digital-Solution web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\core\Application;
use framework\widgets\FlashWidget;
use modules\manager\assets\ManagerBundle;
use framework\widgets\BreadCrumbsWidget;
use \framework\assets\icons\IconsBundle;

$resourceManagerBundlePath = ManagerBundle::register();
$resourceIconBundlePath = IconsBundle::register();
$managerModule = Application::app()->getModule('manager');

header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?=$this->title?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?=$this->head()?>
</head>
<body>
<div class="full-page">
    <header>
        <div class="header-container">
            <div class="logotype">
                <a href="/manager">
                    <img src="<?=$resourceManagerBundlePath?>/img/cms-logo.png" alt="CMS Logotype">
                </a>
            </div>
            <div class="top-menu">
                <ul>
                    <li><a href="/">Посмотреть сайт</a></li>
                    <?php
                    // Разработчик
                    if(Application::app()->identy->can('system')) {
                        echo '<li><a href="/manager/see-log">Состояние</a></li>'.
                            '<li><a href="/manager/modules">Модули</a></li>';
                    }
                    // Администратор
                    if(Application::app()->identy->can('admin')) {
                        echo ' <li><a href="/manager/see-icon">Иконки</a></li>
                    <li><a href="/manager/settings">Настройки</a></li>
                    <li><a href="/manager/clear-assets">Очистить кэш</a></li>';
                    }
                    ?>

                </ul>
            </div>
            <div class="userbar">
                <a href="#" id="profile"><img src="<?=$resourceManagerBundlePath?>/img/no-photo.png" alt="Avatar"> <?=Application::app()->identy->getShortName()?></a>
            </div>
        </div>
    </header>
    <div class="notify">
        <?=FlashWidget::asBlocks()?>
    </div>
    <div class="container">
        <div class="module-container">
            <div class="window">
                <?=$managerModule->menu()?>
            </div>
        </div>
        <div class="main-container">
            <div class="window">
                <div class="breadcrumbs"><?=BreadCrumbsWidget::widget($this->breadcrumbs, ['name' => 'Управление', 'url' => '/manager'])?></div>
                <?=$content?>
            </div>
        </div>
    </div>
</div>

<footer>
    &#169; Система управления сайтом разработана Web-студией Digital-Solution.Ru
</footer>
<?=$this->footer()?>
</body>
</html>

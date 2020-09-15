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
    <title><?= $this->title ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?= $this->head() ?>
</head>
<body>
<div class="wrapper">
    <header>
        <nav class="top-mnu">
            <div class="logo">
                <a href="/manager">
                    <img src="<?= $resourceManagerBundlePath ?>/img/cms-logo.png" alt="CMS Logotype">
                </a>
            </div>

            <ul>
                <li><a href="/"><span class="glyphicon glyphicon-eye-open"></span> Посмотреть сайт</a></li>
                <?php
                // Разработчик
                if (Application::app()->identy->can('system')) {
                    echo '<li><a href="/manager/see-log"><span class="icon icon-info"></span> Состояние</a></li>' .
                        '<li><a href="/manager/modules"><span class="icon icon-tree"></span> Модули</a></li>';
                }
                // Администратор
                if (Application::app()->identy->can('admin')) {
                    echo ' <li><a href="/manager/see-icon"><span class="icon icon-images"></span> Иконки</a></li>
                <li><a href="/manager/settings"><span class="icon icon-cogs"></span> Настройки</a></li>
                <li><a href="/manager/clear-assets"><span class="glyphicon glyphicon-trash"></span> Очистить кэш</a></li>';
                }
                ?>

            </ul>
            <div class="usr">
                <a href="#" id="profile"><img src="<?= $resourceManagerBundlePath ?>/img/no-photo.png"
                                              alt="Avatar"> <?= Application::app()->identy->getShortName() ?></a>
            </div>
        </nav>
    </header>
    <section>
        <div class="workspace">
            <div class="v-mnu">
                <?=$managerModule->bootstrapMenu() ?>
            </div>
            <div class="v-container">
                <?= FlashWidget::asBlocks() ?>
                <?= BreadCrumbsWidget::widget($this->breadcrumbs, ['name' => 'Управление', 'url' => '/manager']) ?>
                <div class="container-fluid">
                <?= $content ?>
                </div>
            </div>
        </div>
    </section>

</div><!-- end of wrapper -->

<?= $this->footer() ?>
</body>
</html>

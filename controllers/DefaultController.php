<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\manager\controllers;

use framework\components\Controller;
use framework\core\Application;


class DefaultController extends Controller
{

    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
        //$calendar = new Calendar();
//
        //$calendar->addEvent(["name" => "Тестовое событие"]);

        // Выбор отображения
        $view = Application::app()->getConfig('defaultAdminView');


       return $this->render('index', []);
    }

    public function actionSeeLog()
    {
        return $this->render('see-log', []);
    }

    public function actionSeeIcon()
    {
        return $this->render('see-icon', []);
    }

    public function actionClearAssets()
    {
        Application::app()->assetManager->clearAssets();
        Application::app()->request->setFlash("success", "Кэш сброшен");
        return $this->redirect('/manager');
    }

}
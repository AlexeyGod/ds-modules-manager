<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\manager\controllers;
use application\models\User;
use framework\components\Settings;
use framework\components\Controller;
use framework\core\Application;
use framework\exceptions\NotFoundHttpException;
use framework\helpers\captcha\Captcha;

class SettingsController extends Controller
{

    protected $layoutPath = '@modules/manager/views/layouts';

    public $view_prefix = '';

    public function __construct(array $options = [])
    {
        $this->view_prefix = (Application::app()->identy->can('system') ? 'system' : 'admin');
        parent::__construct($options);
    }

    public function actionIndex()
    {
        $confings = Application::app()->request->post('configs');
        if(!empty($confings))
        {
            // Сохранение
            Application::app()->getConfigStorage()->updateSettings($confings);
            Application::app()->request->setFlash('success', 'Настройки изменены');
            //exit(var_export($confings, true));
        }

        $settings = Application::app()->getConfigStorage()->reload()->getRows();

       return $this->render($this->view_prefix.'_index', [
           'model' => $settings,
           'view_mode' => $this->view_prefix
       ]);
    }

    public function actionSimpleSettings()
    {
        $this->view_prefix = 'admin';
        return $this->actionIndex();
    }

    public function actionCreate()
    {
        $model =  Application::app()->getConfigStorage();

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'Настройка добавлена');
            return $this->redirect('/manager/settings');
        }

        return $this->render($this->view_prefix.'_update', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Settings::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Настройка с id=".$id." не найдена");

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'Настройка изменена');
        }

        return $this->render($this->view_prefix.'_update', ['model' => $model]);
    }

}
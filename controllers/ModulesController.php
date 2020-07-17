<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\manager\controllers;
use application\models\User;
use framework\components\module\ModuleInstall;
use framework\exceptions\ErrorException;
use framework\models\Modules;
use framework\components\Controller;
use framework\core\Application;
use framework\exceptions\NotFoundHttpException;
use framework\helpers\captcha\Captcha;

class ModulesController extends Controller
{

    protected $layoutPath = '@modules/manager/views/layouts';

    public function actionIndex()
    {
       return $this->render('index', ['model' => Modules::find()->orderBy(['system' => 'asc', 'priority' => 'asc' ])->all()]);
    }

    public function actionUpdate($id)
    {
        $model = Modules::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Моудль с id=".$id." не найден");

        if($model->load(Application::app()->request->post()))
        {
            $model->save();
            Application::app()->request->setFlash('success', 'Модуль изменен');
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionToggle($id)
    {
        $model = Modules::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Моудль с id=".$id." не найден");


        if($model->status == 1)
        {
            $model->status = 0;
            $tAction = 'отключен';
        }
        else
        {
            $model->status = 1;
            $tAction = 'включен';
        }


            $model->save();
        Application::app()->request->setFlash('success', 'Модуль '.$tAction);


        return $this->redirect('/manager/modules/');
    }

    public function actionDelete($id)
    {
        $model = Modules::findOne($id);

        if($model == null)
            throw new NotFoundHttpException("Моудль с id=".$id." не найден");

            $model->delete();
            Application::app()->request->setFlash('success', 'Модуль удален');


        return $this->redirect('/manager/modules');
    }

    // Автоматическая установка
     public function actionInstall()
    {
        /*
        * При установке модуля должны быть записаны следующие данные
            id 
            name  
            class 
            icon 
            priority 
            status
            system
        */

        $model = new Modules();

        if($model->load(Application::app()->request->post()))
        {
            if(!class_exists($model->class))
            {
                Application::app()->request->setFlash('error', 'Указанный класс для модуля '.$model->name.' ('.$model->class.') не существует');
            }
            else
            {
                $mClass = $model->class;

                $installData = $mClass::install();

                $model->loadFromData($installData['data']);

               if($installData['status'] == ModuleInstall::INSTALL_SUCCESS)
               {
                   if($model->save())
                   {
                       Application::app()->request->setFlash('success', 'Модуль успешно установлен');
                       return $this->redirect('/manager/modules');
                   }
                   else
                   {
                       Application::app()->request->setFlash('error', 'Ошибка при сохранении модуля');
                   }

               }
               else
               {
                   Application::app()->request->setFlash('error', 'При установке модуля произошла ошибка: '.$installData['error']);
               }

                return $this->render('install-success', ['model' => $model, 'mClass' => $mClass, 'installData' => $installData]);

            }


        }

        return $this->render('install', ['model' => $model]);
    }

    // Автоматическая установка
    public function actionSmartInstall()
    {
        $modules = [];
        $modulesPath = Application::app()->getAlias('@modules');

        $moduleList = glob($modulesPath.'/*');


        if(is_array($moduleList))
        {
            foreach($moduleList as $item)
                $modules[] = [
                    'path' => $item,
                    'name' => basename($item)
                ];
        }
        /*
        * При установке модуля должны быть записаны следующие данные
            id
            name
            class
            icon
            priority
            status
            system
        */

        $model = new Modules();

        if($model->load(Application::app()->request->post()))
        {
            if(!class_exists($model->class))
            {
                Application::app()->request->setFlash('error', 'Указанный класс для модуля '.$model->name.' ('.$model->class.') не существует');
            }
            else
            {
                $mClass = $model->class;

                $installData = $mClass::install();

                $model->loadFromData($installData['data']);

                if($installData['status'] == ModuleInstall::INSTALL_SUCCESS)
                {
                    if($model->save())
                    {
                        Application::app()->request->setFlash('success', 'Модуль успешно установлен');
                        return $this->redirect('/manager/modules');
                    }
                    else
                    {
                        Application::app()->request->setFlash('error', 'Ошибка при сохранении модуля');
                    }

                }
                else
                {
                    Application::app()->request->setFlash('error', 'При установке модуля произошла ошибка: '.$installData['error']);
                }

                return $this->render('install-success', ['model' => $model, 'mClass' => $mClass, 'installData' => $installData]);

            }


        }

        return $this->render('smart-install', [
            'modulesPath' => $modulesPath,
            'modules' => $modules,
            'model' => $model
        ]);
    }

    public function actionSmartInstallModule($module)
    {
        $className = 'modules\\'.$module.'\\'.ucfirst($module).'Module';
        if(!class_exists($className)) throw new ErrorException("Class модуля ".$className." не существует");

        $installData = $className::install();


        $model = new Modules();

        $model->loadFromData($installData['data']);

        if($installData['status'] == ModuleInstall::INSTALL_SUCCESS)
        {
            if($model->save())
            {
                Application::app()->request->setFlash('success', 'Модуль успешно установлен');
                return $this->redirect('/manager/modules');
            }
            else
            {
                Application::app()->request->setFlash('error', 'Ошибка при сохранении модуля');
            }

        }
        else
        {
            Application::app()->request->setFlash('error', 'При установке модуля произошла ошибка: '.$installData['error']);
        }

        return $this->render('install-success', ['model' => $model, 'mClass' => $className, 'installData' => $installData]);
    }



}
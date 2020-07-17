<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\manager;


use framework\models\Modules;
use framework\components\module\ModuleComponent;
use framework\core\Application;
use framework\exceptions\ErrorException;

class ManagerModule extends ModuleComponent
{
    public $normalize = true;

    //public $modules = ['user', 'content', ]; //'task'];
    public static $access = 'manager';

    public $routes = [
        //'manager/<action:[A-Za-z0-9+_-]+>' => 'manager/<action>',
        //'manager/<controller:[A-Za-z0-9+_-]+>/<action:[A-Za-z0-9+_-]+>' => 'manager/<controller>/<action>',
        //'manager/<controller:[A-Za-z0-9+_-]+>/<action:[A-Za-z0-9+_-]+>/<id:[0-9]+>' => 'manager/<controller>/<action>',

        'manager/<controller:(modules|settings)>/<action:[A-Za-z0-9+_-]+>' => 'manager/<controller>/<action>',
        'manager/modules/<action:[A-Za-z0-9+_-]+>/<id:[0-9]+>' => 'manager/modules/<action>',
        'manager/modules/<action:smart-[A-Za-z0-9+_-]+>/<module:[A-Za-z0-9_-]+>' => 'manager/modules/<action>',

        'manager/<module:[A-Za-z0-9+_-]+>/<controller:[A-Za-z0-9+_-]+>' => '<module>/<controller>',
        'manager/<module:[A-Za-z0-9+_-]+>/<controller:[A-Za-z0-9+_-]+>' => '<module>/<controller>',
        'manager/<module:[A-Za-z0-9+_-]+>/<controller:[A-Za-z0-9+_-]+>/<action:[A-Za-z0-9+_-]+>' => '<module>/<controller>/<action>',
        'manager/<module:[A-Za-z0-9+_-]+>/<controller:[A-Za-z0-9+_-]+>/<action:[A-Za-z0-9+_-]+>/<id:\d+>' => '<module>/<controller>/<action>',
    ];

    protected $_menu = [
        /*
        'accept' => 'system',
        'name' => 'Системные',
        'icon' => 'icon-cogs',
        'links' => [
            [
                'name' => 'Сводная',
                'url' => '/manager',
            ],
            [
                'name' => 'Конфигурация и лог',
                'url' => '/manager/see-log',
            ],
            [
                'name' => 'Список иконок',
                'url' => '/manager/see-icon',
            ],
            [
                'name' => 'Очистить кэш',
                'url' => '/manager/clear-assets',
            ],
            [
                'name' => 'Модули',
                'url' => '/manager/modules',
            ],
            [
                'name' => 'Настройки',
                'url' => '/manager/settings',
            ],

        ]
        */
    ];

    protected $_generalMenu = [];

    public function __construct(array $options = [])
    {
        parent::__construct($options);
        // Формирование меню
        //$this->_generalMenu['manager'] = $this->contextMenu();
        // Подгрузка всех модулей

    }

    public static function getModules()
    {
        return Modules::find(['status' => 1])->all();
    }


    public function stringNormalize($str)
    {
        if($this->normalize)
            $str = htmlspecialchars(stripslashes($str));

        return $str;
    }

    public function menu()
    {
        $developerView = Application::app()->identy->can('developer') ? true : false;
        $modules = self::getModules();
        if(!empty($modules))
        {
            foreach($modules as $module)
            {
                $object = Application::app()->getModule($module->name, $module->class);
                if(!method_exists($object, 'contextMenu'))
                    throw new ErrorException("ManagerModule: Указанный как плагин модуль $module не содержит необходимого метода contextMenu()");

                $this->_generalMenu[$module->name] = $object->contextMenu();
                unset($object);
            }
        }


        $output = "<!-- Module Menu widget -->\n";

        foreach($this->_generalMenu as $realModuleSlug => $item)
        {
            if(empty($item)) continue;

            $active = false;

            if(Application::app()->route->status['module'] == $realModuleSlug)
                $active = true;

            $moduleSlug = "ma-".$realModuleSlug;
            if(!empty($item['accept']) AND !Application::app()->identy->can($item['accept'])) continue;

            $output .= '<div class="module-menu-area">'."\n";
            $output .= "\t".'<div class="module-name">'."\n"
                .'<a class="manage-menu-action" href="#" data-target="'.$moduleSlug.'"><span class="'.$item['icon'].'"></span> '.($item['format'] != 'html' ? $this->stringNormalize($item['name']) : $item['name']).' <span id="m-'.$moduleSlug.'-status-icon" class="icon  icon-folder-open pull-right"></span></a>'."\n";

            if($developerView) $output .= '<p><small>Требует: '.$item['accept'].'</small></p>'."\n";

            $output .= '</div>'."\n";
            $output .= "\t".'<div class="module-menu" id="'.$moduleSlug.'" style="display: '.($active ? 'block' : 'none').'">'."\n\t\t<ul>\n";

                foreach($item['links'] as $link)
                {
                    if(!empty($link['accept']))
                    {
                        if(!Application::app()->identy->can($link['accept'])) continue;
                    }
                    $output .= "\t\t\t".'<li><a href="'.$link['url'].'">'.($link['format'] != 'html' ? $this->stringNormalize($link['name']) : $link['name']).'</a>';
                    if($developerView) $output .= '<p><small>Требует: '.$link['accept'].'</small></p>'."\n";
                    $output .= "</li>\n";
                }

                $output .= "\t\t</ul>\n\t".'</div>'."\n";
            $output .= '</div>';
            $output .= "\n<!--/ Module Menu widget -->\n";
        }

        $js = <<<JS
$(document).ready(function(){
    $(".manage-menu-action").on('click', function(){
        divId = "#"+$(this).attr('data-target');
        $(divId).toggle();
    });
});
JS;
        Application::app()->assetManager->setJsCode($js);

        return $output;
    }


}
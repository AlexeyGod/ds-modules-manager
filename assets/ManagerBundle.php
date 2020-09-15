<?php

/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

namespace modules\manager\assets;

use framework\components\Bundle;
use framework\components\AssetManager;

class ManagerBundle extends Bundle
{
    public  $sourcePath = '@modules/manager/assets/src';

    public  $js = [
        //'js/manage.js'
        //'js/manage.js'
    ];
    public  $css = [
        'css/correct.css'
        //'css/manage.css'
    ];

    public $depends = [
        'framework\\assets\\bootstrap\\BootstrapBundle'
        //'framework\\assets\\jquery\\JqueryBundle'
    ];
}
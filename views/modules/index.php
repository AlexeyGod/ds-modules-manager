<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */
use framework\helpers\grid\GridView;

$this->breadcrumbs[] = ['name' => 'Модули'];
$this->title = 'Настройки';

?>
<h1>Установленные модули | <a href="/manager/modules/smart-install">Все модули</a>
    <a class="button" href="/manager/modules/install"><span>+</span></a>
</h1>
<?
echo GridView::widget($model,[
    'columns' => [
        [
            'attribute' => 'icon',
            'style' => 'text-align: center',
            'value' => function($model)
            {
                $color = (($model->status == 1) ? 'green' : 'inherit');

                if($model->system == 1) $color = '#bc9562';

                return '<span class="'.$model->icon.'" style="font-size: 3em; color: '.$color.'"></span>';
            }
        ],
        [
            'attribute' => 'name',
            'value' => function($model) {
                return '<p><b style="fz12">'.$model->name.'</b></p><br>'
                .'<p><code>'.$model->class.'</code></p>';
            }
        ],
        [
            'name' => 'Действия',
            'columnClass' => '\\framework\\helpers\\grid\\ActiveColumn',
            'template' => '{toggle} {update} {delete}',
            'buttons' => [
                'toggle' => function($model) {
                        if($model->system != 1) return '<a href="/manager/modules/toggle/'.$model->id.'">'.($model->status == 1 ? 'Откл.' : 'Вкл.').'</a>';
                }
            ]
        ]
        //'class',
        //'icon',
        //'priority',
        //'status',
        //'system'
    ]
]);
?>

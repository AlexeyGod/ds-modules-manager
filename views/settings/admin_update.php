<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;


$this->title = 'Меню | '.($model->isNewRecord ? 'Создать' : 'Изменить').' настройку';
$this->breadcrumbs[] = ['url' => '/manager/settings', 'name' => 'Настройки'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];

echo '<div class="p10">';
?>

<?
    $form = ActiveForm::begin();

        foreach ($model->fields as $field)
        {
            if(in_array($field, ['id'])) continue;

            switch($field):
                default:
                    echo '<div class="field">'
                    .'  '.$form->input($model, $field)
                    .'</div>';
                    break;

                case 'type':
                    echo '<div class="field">'
                        .'  '.$form->select($model, $field, $model->getTypes())
                        .'</div>';
                    break;

                endswitch;
        }

    echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
    ActiveForm::end();
echo '</div>';
?>



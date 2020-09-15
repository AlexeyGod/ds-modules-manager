<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;


$this->title = 'Меню | '.($model->isNewRecord ? 'Создать' : 'Изменить').' модуль';
$this->breadcrumbs[] = ['url' => '/manager/modules', 'name' => 'Модули'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Создать' : 'Изменить')];

echo '<div class="container-fluid">';
?>

<?
    $form = ActiveForm::begin();

        foreach ($model->fields as $field)
        {
            if(in_array($field, ['id'])) continue;

            switch($field):

                case 'class':
                    echo '<div class="field">'
                        .'  '.$form->input($model, $field, ['value' => str_replace('\\', '\\\\', $model->{$field})])
                        .'</div>';
                    break;

                default:
                    echo '<div class="field">'
                        .'  '.$form->input($model, $field)
                        .'</div>';
                    break;

            endswitch;
        }

    echo '<div class="field">'.ActiveForm::submit(['value' => 'Сохранить']).'</div>';
    ActiveForm::end();
echo '</div>';
?>



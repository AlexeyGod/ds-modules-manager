<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

use framework\helpers\ActiveForm;


$this->title = 'Меню | '.($model->isNewRecord ? 'Добавить' : 'Изменить').' модуль';
$this->breadcrumbs[] = ['url' => '/manager/modules', 'name' => 'Модули'];
$this->breadcrumbs[] = ['name' => ($model->isNewRecord ? 'Добавить' : 'Изменить')];

echo '<div class="p10">';
?>

<?
    $form = ActiveForm::begin();
        /*
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
        */
         echo '<div class="field">'
              .'  '.$form->input($model, 'class', ['value' => (empty($model->class) ? 'modules\\\ \\\ Module' : str_replace('\\', '\\\\', $model->class))])
              .'</div>';

    echo '<div class="field">'.ActiveForm::submit(['value' => 'Далее →']).'</div>';
    ActiveForm::end();
echo '</div>';
?>



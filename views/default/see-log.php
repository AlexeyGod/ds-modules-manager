<?php
/**
 * Created by Digital-Solution.Ru web-studio.
 * https://digital-solution.ru
 * support@digital-solution.ru
 */

$this->breadcrumbs[] = ['name' => 'Просмотр логов'];
?>
<h1>Версия DS-Framework: <B><?=\framework\core\Application::version()?></B></h1>
<hr>
<pre><? var_dump(\framework\core\Application::app()->getLog()); ?></pre>

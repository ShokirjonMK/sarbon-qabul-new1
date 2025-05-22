<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\ArchiveDoc $model */

$this->title = 'Create Archive Document';
$this->params['breadcrumbs'][] = ['label' => 'Archive Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="archive-doc-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\DirectionBall $model */
/** @var common\models\EduDirection $eduDirection */

$this->title = 'Tahrirlash';
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Ta\'lim yo\'nalishlari'),
    'url' => ['edu-direction/index'],
];
$breadcrumbs['item'][] = [
    'label' => $eduDirection->direction->name.' yo\'nalish ballari',
    'url' => ['index' , 'id' => $eduDirection->id],
];
?>
<div class="direction-ball-update">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php foreach ($breadcrumbs['item'] as $item) : ?>
                <li class='breadcrumb-item'>
                    <?= Html::a($item['label'], $item['url'], ['class' => '']) ?>
                </li>
            <?php endforeach; ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <div class="form-section">
        <div class="form-section_item">
            <?= $this->render('_form', [
                'model' => $model,
                'eduDirection' => $eduDirection,
            ]) ?>
        </div>
    </div>

</div>

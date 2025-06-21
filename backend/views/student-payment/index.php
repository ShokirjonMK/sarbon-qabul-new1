<?php

use common\models\StudentPayment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\StudentPaymentSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'To\'lovlar');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
?>
<div class="student-payment-index">

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

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'F.I.O',
                'contentOptions' => ['date-label' => 'F.I.O'],
                'format' => 'raw',
                'value' => function($model) {
                    return $model->student->fullName ?? '---';
                },
            ],
            [
                'attribute' => 'F.I.O',
                'contentOptions' => ['date-label' => 'F.I.O'],
                'format' => 'raw',
                'value' => function($model) {
                    $student = $model->student;
                    return $student->passport_serial ." | ".$student->passport_number;
                },
            ],
            [
                'attribute' => 'price',
                'contentOptions' => ['date-label' => 'price'],
                'format' => 'raw',
                'value' => function($t) {
                    return number_format($t->price, 0, '', ' ');
                },
            ],
            'payment_date',
            'text',
        ],
    ]); ?>


</div>

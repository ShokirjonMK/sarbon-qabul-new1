<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\ArchiveDocSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = '📦 Arxiv hujjatlar';
$this->params['breadcrumbs'][] = $this->title;

$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];

\yii\web\YiiAsset::register($this);

?>
<div class="archive-doc-index">

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

    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Qo‘shish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-hover table-striped align-middle'],
        'headerRowOptions' => ['class' => 'table-primary text-uppercase text-center'],
        'rowOptions' => ['style' => 'vertical-align:middle;'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'student_full_name',
                'label' => 'Talabaning To‘liq Ismi',
                'contentOptions' => ['style' => 'white-space: normal;'],
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Telefon raqami',
                'value' => function ($model) {
                    return $model->phone_number ?: '(qayt etilmagan)';
                }
            ],
            [
                'attribute' => 'direction',
                'label' => 'Yo‘nalish nomi',
            ],
            [
                'attribute' => 'edu_form',
                'label' => 'Ta\'lim shakli nomi',
            ],
            [
                'attribute' => 'submission_date',
                'label' => 'Hujjat topshirilgan sana',
            ],
            [
                'attribute' => 'application_letter',
                'label' => 'Rektor nomiga ariza',
                'format' => 'raw',
                'value' => fn($model) => $model->application_letter ? '✅' : '❌',
            ],
            [
                'attribute' => 'passport_copy',
                'label' => 'Passport nusxasi',
                'format' => 'raw',
                'value' => fn($model) => $model->passport_copy ? '✅' : '❌',
            ],
            [
                'attribute' => 'diploma_original',
                'label' => 'Diplom yoki attestat (ilova) asl nusxa',
                'format' => 'raw',
                'value' => fn($model) => $model->diploma_original ? '✅' : '❌',
            ],

            [
                'attribute' => 'photo_3x4',
                'label' => '3x4 rasm',
                'format' => 'raw',
                'value' => fn($model) => $model->photo_3x4 ? '✅' : '❌',
            ],
            [
                'attribute' => 'contract_copy',
                'label' => 'Shartnoma nusxasi',
                'format' => 'raw',
                'value' => fn($model) => $model->contract_copy ? '✅' : '❌',
            ],
            [
                'attribute' => 'payment_receipt',
                'label' => 'To‘lov cheki',
                'format' => 'raw',
                'value' => fn($model) => $model->payment_receipt ? '✅' : '❌',
            ],
            [
                'attribute' => 'PDF',
                'label' => 'PDF',
                'format' => 'raw',
                'value' => function($model) {
                    return "<a class='badge-table-div active p-0' href='".Url::to(['archive-doc/pdf', 'id' => $model->id])."'><i class='fa fa-file-pdf'></i></a>";
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}', // faqat ko‘rish
                'buttons' => [
                    'view' => function ($url) {
                        return Html::a('<i class="fa fa-eye"></i>', $url, [
                            'title' => 'Ko‘rish',
                            'class' => 'btn btn-sm btn-outline-primary',
                        ]);
                    },
                ],
                'contentOptions' => ['class' => 'text-center'],
            ],
        ],
    ]); ?>

</div>
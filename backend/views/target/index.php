<?php

use common\models\Target;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Student;

/** @var yii\web\View $this */
/** @var common\models\TargetSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Target');
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];

$baseQuery = Student::find()
    ->alias('s')
    ->innerJoin('user u', 's.user_id = u.id')
    ->where(['u.user_role' => 'student'])
    ->andWhere(['in' , 'u.cons_id', getConsOneIk()])


?>
<div class="target-index">

    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <?php
            foreach ($breadcrumbs['item'] as $item) {
                echo "<li class='breadcrumb-item'><a href='". Url::to($item['url']) ."'>". $item['label'] ."</a></li>";
            }
            ?>
            <li class="breadcrumb-item active" aria-current="page"><?= Html::encode($this->title) ?></li>
        </ol>
    </nav>

    <?php if (permission('target', 'create')): ?>
        <div class="mb-3 mt-4">
            <?= Html::a(Yii::t('app', 'Qo\'shish'), ['create'], ['class' => 'b-btn b-primary']) ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'CONSULTING',
                'contentOptions' => ['date-label' => 'CONSULTING'],
                'format' => 'raw',
                'value' => function($model) {
                    $cons = $model->cons;
                    return "<a href='https://{$cons->domen}' class='badge-table-div active'>".$cons->domen."</a>";
                },
            ],
            'name',

            [
                'attribute' => 'SMS kod tasdiqlamagan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery) {
                    return (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 9,
                            'u.step' => 0,
                            'u.target_id' => $model->id,
                        ])->count();
                }
            ],
            [
                'attribute' => 'Pasport ma\'lumotini kiritmagan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery) {
                    return (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 1,
                            'u.target_id' => $model->id,
                        ])->count();
                }
            ],
            [
                'attribute' => 'Qabul turini tanlamagan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery) {
                    return (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 2,
                            'u.target_id' => $model->id,
                        ])->count();
                }
            ],
            [
                'attribute' => 'Yo\'nalish tanlamagan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery) {
                    return (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 3,
                            'u.target_id' => $model->id,
                        ])->count();
                }
            ],
            [
                'attribute' => 'Tasdiqlamagan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery) {
                    return (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 4,
                            'u.target_id' => $model->id,
                        ])->count();
                }
            ],
            [
                'attribute' => 'To\'liq ro\'yhatdan o\'tgan',
                'format' => 'raw',
                'value' => function ($model) use ($baseQuery) {
                    return (clone $baseQuery)
                        ->andWhere([
                            'u.status' => 10,
                            'u.step' => 5,
                            'u.target_id' => $model->id,
                        ])->count();
                }
            ],
            [
                'class' => ActionColumn::className(),
                'contentOptions' => ['date-label' => 'Harakatlar' , 'class' => 'd-flex justify-content-around'],
                'header'=> 'Harakatlar',
                'buttons'  => [
                    'view'   => function ($url, $model) {
                        if (permission('target', 'view')) {
                            $url = Url::to(['view', 'id' => $model->id]);
                            return Html::a('<i class="fa fa-eye"></i>', $url, [
                                'title' => 'view',
                                'class' => 'tableIcon',
                                "data-bs-toggle" => "modal" , "data-bs-target" => "#targetModal" , 'data-toggle' => "modal",
                            ]);
                        }
                        return false;
                    },
                    'update' => function ($url, $model) {
                        if (permission('target', 'update')) {
                            $url = Url::to(['update', 'id' => $model->id]);
                            return Html::a('<i class="fa-solid fa-pen-to-square"></i>', $url, [
                                'title' => 'update',
                                'class' => 'tableIcon',
                            ]);
                        }
                        return false;
                    },
                    'delete' => function ($url, $model) {
                        if (permission('target', 'delete')) {
                            $url = Url::to(['delete', 'id' => $model->id]);
                            return Html::a('<i class="fa fa-trash"></i>', $url, [
                                'title' => 'delete',
                                'class' => 'tableIcon',
                                'data-confirm' => Yii::t('yii', 'Ma\'lumotni o\'chirishni xoxlaysizmi?'),
                                'data-method'  => 'post',
                            ]);
                        }
                        return false;
                    },
                ],
            ],
        ],
    ]); ?>
</div>

<div class="modal fade" id="targetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="form-section">
                <div class="form-section_item">
                    <div class="modal-body" id="targetModalBody">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
    $('#targetModal').on('show.bs.modal', function (e) {
        var button = $(e.relatedTarget);
        var url = button.attr('href');
        $(this).find('#targetModalBody').load(url);
    });
JS;
$this->registerJs($js);
?>

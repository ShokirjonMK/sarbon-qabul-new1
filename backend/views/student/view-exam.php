<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\StudentOferta;
use common\models\Exam;
use common\models\StudentPerevot;
use common\models\StudentMaster;
use common\models\StudentDtm;
use common\models\Course;
use yii\helpers\Url;
use common\models\ExamDate;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var common\models\Student $model */

$this->title = $model->fullName;

$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
if ($model->edu_type_id != null) {
    $breadcrumbs['item'][] = [
        'label' => $model->eduType->name_uz,
        'url' => ['index', 'id' => $model->edu_type_id],
    ];
} else {
    $breadcrumbs['item'][] = [
        'label' => 'Chala arizalar',
        'url' => ['chala'],
    ];
}


\yii\web\YiiAsset::register($this);
?>
<div class="page">
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

    <div class="page-item mb-4">
        <div class="row">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // [
                    //     'attribute' => 'question_id',
                    //     'label' => 'Savol',
                    //     'value' => fn($model) => $model->question->text ?? '(yo‘q)',
                    // ],
                    // [
                    //     'attribute' => 'question_id',
                    //     'label' => 'Savol',
                    //     'format' => 'ntext',
                    //     'value' => fn($model) => isset($model->question->text) ? strip_tags($model->question->text) : '(yo‘q)',
                    // ],
                    [
                        'attribute' => 'question_id',
                        'label' => 'Savol',
                        'format' => 'ntext',
                        'value' => fn($model) => isset($model->question->text)
                            ? trim(html_entity_decode(strip_tags($model->question->text)))
                            : '(yo‘q)',
                    ],
                    [
                        'attribute' => 'option',
                        'label' => 'Tanlangan javob',
                        'format' => 'raw',
                        'value' => fn($model) => $model->option,
                    ],
                    [
                        'attribute' => 'is_correct',
                        'label' => 'To‘g‘rimi?',
                        'format' => 'raw',
                        'value' => fn($model) => $model->is_correct ? '<span class="badge bg-success">To‘g‘ri</span>' : '<span class="badge bg-danger">Noto‘g‘ri</span>',
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => ['datetime', 'php:Y-m-d H:i'],
                        'label' => 'Yaratilgan',
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['datetime', 'php:Y-m-d H:i'],
                        'label' => 'O‘zgartirilgan',
                    ],
                ],
            ]) ?>
        </div>
    </div>


</div>




<?php
$js = <<<JS
$(document).ready(function() {
    
});
JS;
$this->registerJs($js);
?>
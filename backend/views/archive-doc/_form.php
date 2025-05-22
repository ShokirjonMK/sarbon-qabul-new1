<?php

use common\models\Student;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/** @var yii\web\View $this */
/** @var app\models\ArchiveDoc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="archive-doc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(
                Student::find()->where(["is_deleted"=>0])->all(),
            'id',
            function ($model) {
                return $model->first_name . ' ' . $model->last_name . ' ' . $model->middle_name .
                    ' | 📞 ' . $model->student_phone .
                    ' | 🆔 ' . $model->passport_serial . $model->passport_number .
                    ' | PIN: ' . $model->passport_pin;
            }
        ),
        'options' => ['placeholder' => 'Talabani tanlang...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <hr>
    <h4>📎 Hujjatlar</h4>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'application_letter')->checkbox() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'passport_copy')->checkbox() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'diploma_original')->checkbox() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'photo_3x4')->checkbox() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'contract_copy')->checkbox() ?></div>
        <div class="col-md-6"><?= $form->field($model, 'payment_receipt')->checkbox() ?></div>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
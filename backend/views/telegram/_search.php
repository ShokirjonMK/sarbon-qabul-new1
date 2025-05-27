<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TelegramSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="telegram-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'telegram_id') ?>

    <?= $form->field($model, 'phone') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'step') ?>

    <?php // echo $form->field($model, 'lang_id') ?>

    <?php // echo $form->field($model, 'birthday') ?>

    <?php // echo $form->field($model, 'passport_number') ?>

    <?php // echo $form->field($model, 'passport_serial') ?>

    <?php // echo $form->field($model, 'passport_pin') ?>

    <?php // echo $form->field($model, 'edu_type_id') ?>

    <?php // echo $form->field($model, 'edu_form_id') ?>

    <?php // echo $form->field($model, 'edu_lang_id') ?>

    <?php // echo $form->field($model, 'edu_direction_id') ?>

    <?php // echo $form->field($model, 'direction_course_id') ?>

    <?php // echo $form->field($model, 'exam_type') ?>

    <?php // echo $form->field($model, 'branch_id') ?>

    <?php // echo $form->field($model, 'exam_date_id') ?>

    <?php // echo $form->field($model, 'cons_id') ?>

    <?php // echo $form->field($model, 'oferta') ?>

    <?php // echo $form->field($model, 'tr') ?>

    <?php // echo $form->field($model, 'dtm') ?>

    <?php // echo $form->field($model, 'master') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'is_deleted') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

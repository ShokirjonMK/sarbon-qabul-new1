<?php

use yii\helpers\Html;

/** @var app\models\ArchiveDoc $model */
?>

<style>
    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12pt;
    }

    h3,
    h4 {
        text-align: center;
        margin: 5px 0;
    }

    .section {
        margin-top: 20px;
    }

    .label {
        font-weight: bold;
    }

    table {
        margin-left: -10px;
    }

    .check {
        font-weight: bold;
        color: #28a745;
    }

    .nocheck {
        font-weight: bold;
        color: #dc3545;
    }
</style>

<h3>O‘ZBEKISTON RESPUBLIKASI OLIY TA’LIM, FAN VA INNOVATSIYALAR VAZIRLIGI</h3>
<h4>SARBON UNIVERSITETI</h4>

<div class="section">
    <p><span class="label">Ta’lim yo‘nalishi: </span> <?= Html::encode($model->direction) ?></p>
    <p><span class="label">Ta’lim shakli: </span> <?= Html::encode($model->edu_form) ?></p>
    <p><span class="label">Talaba FIO: </span> <?= Html::encode($model->student_full_name) ?></p>
    <p><span class="label">Telefon raqami: </span> <?= Html::encode($model->phone_number) ?></p>
    <p><span class="label">Hujjat topshirilgan sana: </span> <?= Yii::$app->formatter->asDate($model->submission_date, 'php:Y-m-d') ?></p>
</div>

<div class="section">
    <h4>HUJJATLAR RO‘YXATI</h4>
    <p></p>

    <table style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>#</th>
            <th>Hujjat nomi</th>
            <th>Holat</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Rektor nomiga ariza</td>
            <td class="<?= $model->application_letter ? 'yes' : 'no' ?>"><?= $model->application_letter ? 'Ha' : 'Yo‘q' ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Passport nusxasi</td>
            <td class="<?= $model->passport_copy ? 'yes' : 'no' ?>"><?= $model->passport_copy ? 'Ha' : 'Yo‘q' ?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Diplom yoki attestat (ilova) asl nusxa</td>
            <td class="<?= $model->diploma_original ? 'yes' : 'no' ?>"><?= $model->diploma_original ? 'Ha' : 'Yo‘q' ?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>3x4 rasm</td>
            <td class="<?= $model->photo_3x4 ? 'yes' : 'no' ?>"><?= $model->photo_3x4 ? 'Ha' : 'Yo‘q' ?></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Shartnoma nusxasi</td>
            <td class="<?= $model->contract_copy ? 'yes' : 'no' ?>"><?= $model->contract_copy ? 'Ha' : 'Yo‘q' ?></td>
        </tr>
        <tr>
            <td>6</td>
            <td>To‘lov cheki</td>
            <td class="<?= $model->payment_receipt ? 'yes' : 'no' ?>"><?= $model->payment_receipt ? 'Ha' : 'Yo‘q' ?></td>
        </tr>
    </table>

</div>

<div class="section" style="text-align: center; margin-top: 50px;">
    <p style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">Toshkent – <?= date('Y') ?> yil</p>

</div>
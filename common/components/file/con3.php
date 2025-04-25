<?php

use common\models\Student;
use common\models\Direction;
use common\models\Exam;
use common\models\StudentPerevot;
use common\models\StudentDtm;
use common\models\Course;
use Da\QrCode\QrCode;
use frontend\models\Contract;
use common\models\User;
use common\models\Consulting;
use common\models\StudentMaster;
use common\models\Branch;

/** @var Student $student */
/** @var Direction $direction */
/** @var User $user */

function   ikYearUz($number)
{
    $years = floor($number);

    $months = round(($number - $years) * 12);

    if ($months == 12) {
        $years++;
        $months = 0;
    }

    return "$years yil $months oy";
}
function   ikYearRu($number)
{
    $years = floor($number);

    $months = round(($number - $years) * 12);

    if ($months == 12) {
        $years++;
        $months = 0;
    }

    return "$years года и $months месяцев";
}
$user = $student->user;
$cons = Consulting::findOne($user->cons_id);
$eduDirection = $student->eduDirection;
$direction = $eduDirection->direction;
$full_name = $student->last_name . ' ' . $student->first_name . ' ' . $student->middle_name;
$code = '';
$joy = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$date = '';
$link = '';
$con2 = '';
if ($student->edu_type_id == 1) {
    $contract = Exam::findOne([
        'edu_direction_id' => $eduDirection->id,
        'student_id' => $student->id,
        'status' => 3,
        'is_deleted' => 0
    ]);
    $code = 'Q3/' . $cons->code . '/' . $contract->id;
    $date = date("Y-m-d H:i", $contract->confirm_date);
    $link = '1&id=' . $contract->id;
    $con2 = '3' . $contract->invois;
    $contract->down_time = time();
    $contract->save(false);
} elseif ($student->edu_type_id == 2) {
    $contract = StudentPerevot::findOne([
        'edu_direction_id' => $eduDirection->id,
        'student_id' => $student->id,
        'file_status' => 2,
        'is_deleted' => 0
    ]);
    $code = 'P3/' . $cons->code . '/' . $contract->id;
    $date = date("Y-m-d H:i", $contract->confirm_date);
    $link = '2&id=' . $contract->id;
    $con2 = '3' . $contract->invois;
    $contract->down_time = time();
    $contract->save(false);
} elseif ($student->edu_type_id == 3) {
    $contract = StudentDtm::findOne([
        'edu_direction_id' => $eduDirection->id,
        'student_id' => $student->id,
        'file_status' => 2,
        'is_deleted' => 0
    ]);
    $code = 'D3/' . $cons->code . '/' . $contract->id;
    $date = date("Y-m-d H:i:s", $contract->confirm_date);
    $link = '3&id=' . $contract->id;
    $con2 = '3' . $contract->invois;
    $contract->down_time = time();
    $contract->save(false);
} elseif ($student->edu_type_id == 4) {
    $contract = StudentMaster::findOne([
        'edu_direction_id' => $eduDirection->id,
        'student_id' => $student->id,
        'file_status' => 2,
        'is_deleted' => 0
    ]);
    $code = 'M3/' . $cons->code . '/' . $contract->id;
    $date = date("Y-m-d H:i:s", $contract->confirm_date);
    $link = '4&id=' . $contract->id;
    $con2 = '3' . $contract->invois;
    $contract->down_time = time();
    $contract->save(false);
}

$student->is_down = 1;
$student->update(false);

$filial = Branch::findOne($student->branch_id);

$trType = $direction->type;

$number = '';
$mfo = '';
$bankUz = '';
$bankRu = '';
$inn = '';
if ($cons->hr != null) {
    $hrs = json_decode($cons->hr, true);
    foreach ($hrs as $key => $hr) {
        if ($key == $trType) {
            $number = $hr['number'] ?? null;
            $mfo = $hr['mfo'] ?? null;
            $bankUz = $hr['bankUz'] ?? null;
            $bankRu = $hr['bankRu'] ?? null;
            $inn = $hr['inn'] ?? null;
            break;
        }
    }
}


$qr = (new QrCode('https://qabul.sarbon.university/site/contract?key=' . $link . '&type=3'))
    ->setSize(120, 120)
    ->setMargin(10)
    ->setForegroundColor(1, 89, 101);
$img = $qr->writeDataUri();

$lqr = (new QrCode('https://license.gov.uz/registry/abd0350c-93de-4723-a71f-f0513b945c19'))->setSize(100, 100)
    ->setMargin(10)
    ->setForegroundColor(1, 89, 101);
$limg = $lqr->writeDataUri();

?>

<table width="100%" style="font-family: 'Times New Roman'; font-size: 13px; border-collapse: collapse;" cellpadding="8px">



    <tr>
        <td colspan="2" style="text-align: justify; vertical-align: top; border: 1px solid #000; ">
            7.1 Ta’lim muassasasi: <b><?= $filial->name_uz ?></b> <br>
            <b>Manzil:</b> <?= $filial->address_uz ?> <br>
            Bank rekvizitlari:<br>
            <b>H/R: </b> <?= $number ?> <br>
            <b>Bank: </b> <?= $bankUz ?> <br>
            <b>Bank kodi (MFO): </b> <?= $mfo ?> <br>
            <b>STIR (INN): </b> <?= $inn ?> <br>
            <b>Telefon: </b> +998 78 888 22 88 <br>
            <img src="<?= $img ?>" width="120px">
        </td>
        <td colspan="2" style="text-align: justify; vertical-align: top; border: 1px solid #000; ">
            7.1. Образовательное учреждение: <b><?= $filial->name_uz ?></b> <br>
            <b>Адрес: </b> <?= $filial->address_ru ?> <br>
            Банковские реквизиты:<br>
            <b>Расчетный счет: </b> <?= $number ?> <br>
            <b>Банк: </b> <?= $bankRu ?> <br>
            <b>Код банка (МФО): </b> <?= $mfo ?><br>
            <b>ИНН: </b> <?= $inn ?> <br>
            <b>Тел: </b> +998 78 888 22 88 <br>
            <img src="<?= $limg ?>" width="120px"> <br>
        </td>
    </tr>

    <tr>
        <td colspan="2" style="text-align: left; vertical-align: center; border: 1px solid #000; ">

        </td>
        <td colspan="2" style="text-align: right; vertical-align: center; border: 1px solid #000; ">
            <b>Дата и номер лицензии</b>
            14.09.2024 <b>№ 397374</b>
        </td>
    </tr>


    <tr>
        <td colspan="2" style="text-align: left; vertical-align: center; border: 1px solid #000; ">
            <b>7.2. Ta’lim oluvchi:</b>
        </td>
        <td colspan="2" style="text-align: left; vertical-align: center; border: 1px solid #000; ">
            <b>7.2. Обучающийся:</b>
        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            F.I.Sh.:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <b
                </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Ф.И.О.:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <b
                </td>
    </tr>


    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Pasport ma’lumotlari:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <?= $student->passport_serial . ' ' . $student->passport_number ?>
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Данные паспорта:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <?= $student->passport_serial . ' ' . $student->passport_number ?>
        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            JShShIR:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <?= $student->passport_pin ?>
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            ПИНФЛ:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <?= $student->passport_pin ?>
        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Telefon raqami:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <?= $student->user->username ?>
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Номер телефона:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            <?= $student->user->username ?>
        </td>
    </tr>


    <tr>
        <td colspan="2" style="text-align: left; vertical-align: center; border: 1px solid #000; ">
            <b>7.3. Buyurtmachi:</b>
        </td>
        <td colspan="2" style="text-align: left; vertical-align: center; border: 1px solid #000; ">
            <b>7.3. Заказчик:</b>
        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Yuridik shaxs:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Юридическое лицо:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Manzil:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Адрес:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            H/r:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Расчетный счет:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Bank:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Банк:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            MFO:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            МФО:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            STIR:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            ИНН:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Tel:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Телефон:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            E-mail:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Электронная почта:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>

    <tr>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Rahbar:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">
            Руководитель:
        </td>
        <td colspan="1" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: left; vertical-align: top; border: 1px solid #000; ">

        </td>
    </tr>


</table>
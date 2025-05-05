<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use Da\QrCode\QrCode;

/** @var yii\web\View $this */
/** @var common\models\Target $model */

$this->title = $model->name;
$breadcrumbs = [];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Bosh sahifa'),
    'url' => ['/'],
];
$breadcrumbs['item'][] = [
    'label' => Yii::t('app', 'Target'),
    'url' => ['index'],
];
\yii\web\YiiAsset::register($this);
?>
<div class="target-view">

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

    <p class="mb-3">
        <?php if (permission('target', 'update')): ?>
            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'b-btn b-primary']) ?>
        <?php endif; ?>

        <?php if (permission('target', 'delete')): ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'b-btn b-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Ma\'lumotni o\'chirishni xoxlaysizmi?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif; ?>
    </p>

    <div class="grid-view">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'name',
            ],
        ]) ?>
    </div>

    <div class="form-section mt-3">
        <div class="form-section_item">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <?php
                    $url = "https://global.softline?id=".$model->id;
                    ?>
                    <h6 class="badge-table-div active"><?= $url ?></h6>
                    <div class="mt-3">
                        <?php
                        $lqr = (new QrCode($url))->setSize(300, 300)
                            ->setMargin(5);
                        $limg = $lqr->writeDataUri();
                        ?>
                        <img src="<?= $limg ?>" width="200px">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <?php
                    $url2 = "https://qabul.tpu.uz/site/sign-up?id=".$model->id;
                    ?>
                    <h6 class="badge-table-div active"><?= $url2 ?></h6>
                    <div class="mt-3">
                        <?php
                        $lqr2 = (new QrCode($url2))->setSize(300, 300)
                            ->setMargin(5);
                        $limg2 = $lqr2->writeDataUri();
                        ?>
                        <img src="<?= $limg2 ?>" width="200px">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

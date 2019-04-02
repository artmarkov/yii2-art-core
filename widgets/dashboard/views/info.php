<?php
use artsoft\Art;

/* @var $this yii\web\View */
?>

<div class="pull-<?= $position ?> col-xs-12 col-md-<?= $width ?> widget-height-<?= $height ?>">
    <div class="panel panel-default">
        <div class="panel-heading"><?= Yii::t('art', 'System Info') ?></div>
        <div class="panel-body">
            <b><?= Yii::t('art', 'Art CMS Version') ?>:</b> <?= Yii::$app->params['version']; ?><br/>
            <b><?= Yii::t('art', 'Art Core Version') ?>:</b> <?= Art::getVersion(); ?><br/>
            <b><?= Yii::t('art', 'Yii Framework Version') ?>:</b> <?= Yii::getVersion(); ?><br/>
            <b><?= Yii::t('art', 'PHP Version') ?>:</b> <?= phpversion(); ?><br/>
        </div>
    </div>
</div>
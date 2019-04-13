<?php

use backend\assets\AppAsset;
use artsoft\assets\MetisMenuAsset;
use artsoft\assets\ArtAsset;
use artsoft\models\Menu;
use artsoft\widgets\LanguageSelector;
use artsoft\widgets\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$assetBundle = ArtAsset::register($this);
MetisMenuAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">

    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <?php
        $logo = $assetBundle->baseUrl . '/images/art-logo-inverse.png';
        NavBar::begin([
            'brandLabel' => Html::img($logo, ['class' => 'art-logo', 'alt' => 'ArtSoft CMS']) . '<b>ArtSoft</b> ' . Yii::t('art', 'Control Panel'),
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-static-top', //navbar-inverse navbar-default
                'style' => 'margin-bottom: 0'
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid'
            ]
        ]);

        $menuItems = [
            ['label' => str_replace('http://', '', Yii::$app->urlManager->hostInfo), 'url' => Yii::$app->urlManager->hostInfo],
        ];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => '<i class="fa fa-sign-in" style="margin-right: 5px;"></i>' . Yii::t('art', 'Login'), 'url' => ['/auth/login']];
        } else {
            $menuItems[] = [
                'label' => '<i class="fa fa-sign-out" style="margin-right: 5px;"></i>' . Yii::t('art', 'Logout {username}', ['username' => Yii::$app->user->identity->username]),
                'url' => Yii::$app->urlManager->hostInfo . '/auth/logout',
                'linkOptions' => ['data-method' => 'post']
            ];
        }

        echo Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);

        echo LanguageSelector::widget(['display' => 'label']);
        
        NavBar::end();
        ?>

        <!-- SIDEBAR NAV -->
        <div class="navbar-default sidebar metismenu" role="navigation">
            <?= Nav::widget([
                'encodeLabels' => false,
                'dropDownCaret' => '<span class="arrow"></span>',
                'options' => [
                    ['class' => 'nav side-menu'],
                    ['class' => 'nav nav-second-level'],
                    ['class' => 'nav nav-third-level']
                ],
                'items' => Menu::getMenuItems('admin-menu'),
            ]) ?>
        </div>
        <!-- !SIDEBAR NAV -->
    </nav>

    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <?php if (Yii::$app->session->hasFlash('crudMessage')): ?>
                        <div class="alert alert-info alert-dismissible alert-crud" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= Yii::$app->session->getFlash('crudMessage') ?>
                        </div>
                    <?php endif; ?>

                    <?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
                    
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

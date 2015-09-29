<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
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
    <?php
        NavBar::begin([
            'brandLabel' => 'Ads system - Admin panel',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
        
        $menuItems = [
            ['label' => 'Home', 'url' => Url::toRoute('/')],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Site', 'url' => Url::toRoute('/../')];
            $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
        } else {
            $menuItems[] = ['label' => 'Export', 'url' => ['/export/index']];
            $menuItems[] = ['label' => 'Ads', 'url' => ['/ad/index']];
            $menuItems[] = ['label' => 'Jobs', 'url' => ['/job/index']];
            $menuItems[] = ['label' => 'Newspapers', 'url' => ['/newspaper/index']];
            $menuItems[] = ['label' => 'Site', 'url' => Url::toRoute('/../')];
            $menuItems[] = [
                'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                'url' => ['/user/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];
        }
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => $menuItems,
        ]);
        NavBar::end();
    ?>
    
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        
        <?php
            if (Yii::$app->controller->module->id == 'rbac_admin') {
                $links = [
                    ['label' => Yii::t('app', 'Assignments'), 'url' => Url::to(['/rbac_admin/assignment'])],
                    ['label' => Yii::t('app', 'Roles'), 'url' => Url::to(['/rbac_admin/role'])],
                    ['label' => Yii::t('app', 'Routes'), 'url' => Url::to(['/rbac_admin/route'])],
                ];
                echo Breadcrumbs::widget([
                    'links' => $links,
                    'homeLink' => false,
                ]);
            }
        ?>
        
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left"><?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

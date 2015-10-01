<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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
                    'brandLabel' => 'Ads system',
                    'brandUrl' => Yii::$app->homeUrl,
                    'options' => [
                        'class' => 'navbar-inverse navbar-fixed-top',
                    ],
                ]);
                $menuItems = [
                    ['label' => 'Home', 'url' => Url::toRoute('/')],
                ];
                if (Yii::$app->user->isGuest) {
                    // $menuItems[] = ['label' => 'Registration', 'url' => ['/user/register']];
                    $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
                } else {
                    if (Yii::$app->user->can('admin')) {
                        $menuItems[] = ['label' => 'Admin', 'url' => Url::toRoute('/admin')];
                    }

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
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left"><?= date('Y') ?></p>
            </div>
        </footer>

        <?php $this->endBody() ?>
        <script src="<?= Url::home() ?>js/main.js"></script>
    </body>
</html>
<?php $this->endPage() ?>

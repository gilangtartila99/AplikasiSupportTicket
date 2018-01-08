<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <?= Html::csrfMetaTags() ?>
    <title>Support Ticket</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Html::img("images/logo.png", ['width' => '4%']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbarku navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
            $menu = [
                ['label' => 'Home', 'url' => ['/site/home']],
                ['label' => 'Login', 'url' => ['/site/login']],
            ];
        } else {
            if (Yii::$app->user->identity->role === 1){
                $menu = [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'User', 'url' => ['/users/index']],
                    ['label' => 'Category', 'url' => ['/category/index']],
                    ['label' => 'Ticket', 'url' => ['/ticket/index']],
                    [
                        'label' => 'Profile <span class="badge">'. Yii::$app->user->identity->username .'</span>',
                        'items' => [
                            ['label' => '<font size="3"><b>'.Yii::$app->user->identity->nama_partner.'</b></font>'],
                            ['label' => 'My Profile', 'url' => ['/users/view', 'id' => Yii::$app->user->identity->id]],
                            '<li class="divider"></li>',
                            ['label' => 'Logout', 'url' => ['/site/logout']],
                        ],
                    ],
                ];
            } elseif(Yii::$app->user->identity->role === 2) {
                $menu = [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    ['label' => 'Ticket', 'url' => ['/ticket/index']],
                    [
                        'label' => 'Profile <span class="badge">'. Yii::$app->user->identity->username .'</span>',
                        'items' => [
                            ['label' => '<font size="3"><b>'.Yii::$app->user->identity->nama_partner.'</b></font>'],
                            ['label' => 'My Profile', 'url' => ['/site/viewuser', 'id' => Yii::$app->user->identity->id]],
                            '<li class="divider"></li>',
                            ['label' => 'Logout', 'url' => ['/site/logout']],
                        ],
                    ],
                ];
            } else {
                $menu = [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    [
                        'label' => 'My Ticket',
                        'items' => [
                            ['label' => 'Open Ticket', 'url' => ['/site/createticket']],
                            ['label' => 'Support Ticket', 'url' => ['/site/ticket']],
                        ],
                    ],
                    [
                        'label' => 'Profile <span class="badge">'. Yii::$app->user->identity->username .'</span>',
                        'items' => [
                            ['label' => '<font size="3"><b>'.Yii::$app->user->identity->nama_partner.'</b></font>'],
                            ['label' => 'My Profile', 'url' => ['/site/viewuser', 'id' => Yii::$app->user->identity->id]],
                            '<li class="divider"></li>',
                            ['label' => 'Logout', 'url' => ['/site/logout']],
                        ],
                    ],
                ];
            }
        }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right navbaru'],
        'items' => $menu,
        'encodeLabels' => false,
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
        <p class="pull-left">&copy; Support Ticket <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

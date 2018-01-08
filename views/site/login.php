<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .kotak {
        padding-left: 30px;
        padding-right: 30px;
        padding-bottom: 30px;
        padding-top: 30px;
        margin-left: 25%; 
        margin-right: 25%;
        width: 50%;
    }
</style>
<div class="site-login thumbnail kotak">
    <h1 align="center"><?= Html::encode($this->title) ?></h1>

    <p align="center">Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
    ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <center>
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('Signup', ['site/createuser'], ['class' => 'btn btn-danger']) ?>
        </center>


    <?php ActiveForm::end(); ?>
</div>

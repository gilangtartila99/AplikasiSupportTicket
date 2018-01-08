<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    .myform {
        float: right;
        width: 20%;
        margin-top: 3%;
    }
    .mytombol {
        opacity: 1;
    }
</style>

<div class="users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="myform">
        <?= $form->field($model, 'role')->dropDownList(['prompt' => 'Select Role', '' => 'Semua', 1 => 'Administrator', 2 => 'Support', 3 => 'User'],['onchange'=>'this.form.submit()'])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

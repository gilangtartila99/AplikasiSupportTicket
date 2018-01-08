<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TicketSearch */
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

<div class="ticket-search">

    <?php $form = ActiveForm::begin([
        'action' => ['ticket'],
        'method' => 'get',
    ]); ?>

    <div class="myform">
        <?= $form->field($model, 'prioritas')->dropDownList(['prompt' => 'Select Prioritas', '' => 'Semua', 'Tinggi' => 'Tinggi', 'Sedang' => 'Sedang', 'Rendah' => 'Rendah'],['onchange'=>'this.form.submit()'])->label(false) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Komentar */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
	.formchat {
		float: left;
		width: 94%;
	}
	.btnchat {
		float: right;
	}
</style>
<div class="komentar-form">

    <?php $form = ActiveForm::begin(); ?>
	    <div class="formchat">
	    	<?= $form->field($models, 'chat')->textInput(['placeholder' => 'Chat'])->label(false) ?>
	    </div>
	    <div class="btnchat">
        	<?= Html::submitButton('Send', ['id' => 'btnchat','class' => 'btn btn-danger btnchat']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

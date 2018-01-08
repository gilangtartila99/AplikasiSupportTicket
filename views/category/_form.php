<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Users;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_category')->dropDownList([
    	'prompt'=>'Select Category', 
    	'Jaringan' => 'Jaringan', 
    	'Bugs' => 'Bugs', 
    	'Technical Support' => 'Technical Support',
    	'Konsultasi' => 'Konsultasi', 
    	'Permintaan Data' => 'Permintaan Data', 
    	'Human Error' => 'Human Error',
    	'Gawean' => 'Gawean'
    ]) ?>

    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(Users::find()->where(['role' => 2])->all(),'id','nama_partner'),['prompt'=>'Select User']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

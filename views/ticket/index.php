<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Report', ['cetaklaporan'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin([
        'id' => 'mypjax',
        'enablePushState' => false,
    ]); ?>   

    <?php 
    if(Yii::$app->user->identity->role == 1) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions'=>function($model){
                    if($model->state == 'Close'){
                        return ['class' => 'danger'];
                    } else {
                        return ['class' => 'success'];
                    }
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id_ticket',
                'subject',
                'prioritas',
                [
                    'label' => 'Category',
                    'attribute' => 'nama_category',
                    'value' => 'category.nama_category'
                ],
                'state',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {transfer} {closenow}',
                    'buttons' => [
                        'view' => function ($url, $model, $key) {
                            return '<p>'.Html::a('View', ['view', 'id' => $model->id_ticket], ['class' => 'btn btn-success']);
                        },
                        'transfer' => function ($url, $model, $key) {
                            return '<p>'.Html::a('Transfer to Support', ['transfer', 'id' => $model->id_ticket], ['class' => 'btn btn-primary']);
                        },
                        'closenow' => function ($url, $model, $key) {
                            return '<p>'.Html::a('Close Now', ['closenow', 'id' => $model->id_ticket], ['class' => 'btn btn-danger']);
                        },
                    ],  
                ],
            ],
        ]);
    } else {
        echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function($model){
                if($model->state == 'Close'){
                    return ['class' => 'danger'];
                } else {
                    return ['class' => 'success'];
                }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id_ticket',
            'subject',
            'prioritas',
            [
                'label' => 'Category',
                'attribute' => 'nama_category',
                'value' => 'category.nama_category'
            ],
            'state',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {transfer} {closenow}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return '<p>'.Html::a('View', ['view', 'id' => $model->id_ticket], ['class' => 'btn btn-success']);
                    },
                    'closenow' => function ($url, $model, $key) {
                        return '<p>'.Html::a('Close Now', ['closenow', 'id' => $model->id_ticket], ['class' => 'btn btn-danger']);
                    },
                ],  
            ],
        ],
    ]);
        } ?>
    <?php Pjax::end(); ?>

<?php
$js = <<<JS
$.pjax.reload({container:'#mypjax'});
JS;
$this->registerJs($js);
?>  
</div>


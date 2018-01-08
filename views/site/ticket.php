<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin([
        'id' => 'mypjax',
        'enablePushState' => false,
    ]); ?>   
    <?= GridView::widget([
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
            //'prioritas',
            [
                'label' => 'Category',
                'attribute' => 'nama_category',
                'value' => 'category.nama_category'
            ],
            'state',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{viewticket} {closenow}',
                'buttons' => [
                    'viewticket' => function ($url, $model, $key) {
                        return '<p>'.Html::a('View', ['viewticket', 'id' => $model->id_ticket], ['class' => 'btn btn-success']);
                    },
                    'closenow' => function ($url, $model, $key) {
                        return '<p>'.Html::a('Close Now', ['closenow', 'id' => $model->id_ticket], ['class' => 'btn btn-danger']);
                    },
                ],  
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

<?php
$js = <<<JS
$.pjax.reload({container:'#mypjax'});
JS;
$this->registerJs($js);
?>  
</div>


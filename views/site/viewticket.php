<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Ticket */

$this->title = $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .border {
        border-color: #CDCCCC;
    }
    .tabelku {
        padding-top: 2%;
        padding-left: 2%;
        padding-bottom: 2%;
        padding-right: 2%;
    }
    .tabelku2 {
        padding-top: 1%;
        padding-left: 1%;
        padding-bottom: 1%;
        padding-right: 1%;
    }
</style>
<div class="ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <table width="100%" border="2" cellpadding="6" cellspacing="6" class="border">
        <tr class="tabelku">
            <td width="30%" align="center" class="tabelku">
                <table width="100%" border="2" cellpadding="5" cellspacing="5" class="jarak border">
                    <tr class="tabelku2">
                        <td width="30%" align="center" class="tabelku2">
                            <p><font size="4"><b>Category Support Ticket</b></font></p>
                            <font size="3"><?= $model->category->nama_category ?></font>
                        </td>
                        <td width="30%" align="center" class="tabelku2">
                            <p><font size="4"><b>Prioritas</b></font></p>
                            <font size="3"><?= $model->prioritas ?></font>
                        </td>
                        <td width="30%" align="center" class="tabelku2">
                            <p><font size="4"><b>State</b></font></p>
                            <font size="3"><?= $model->state ?></font>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_ticket',
            'users.nama_partner',
            'subject',
            'description',
            [
                'label' => 'Attachment',
                'value' =>  Html::a('<p>'.Html::img("attachment/file.png", ['width' => '100px']).'</p><b><font>'.$model->attachment.'</font></b>', Url::to(['downloadfile', 'id' => $model->id_ticket])),
                'format' => 'raw'
            ],
        ],
    ]) ?>

    <br> 

    <style type="text/css">
        .chat {
            margin-left: 5%;
            margin-right: 5%;
            width: 100%;
        }
    </style>

    <div class="thumbnail chat">

        <h2 align="center">Chating</h2>

        <div class="thumbnail">
            <?= $this->render('chat', [
                'model' => $model,
                'models' => $models,
            ]) ?>
        </div>

        <br>

        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items}{pager}',
            'itemView' => 'allchat',
        ]) ?>
    </div>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\Markdown;

?>

<style type="text/css">
    .warna {
        color: #000000;
        background-color: transparent;
        border-style: solid;
        border-width: 1px;
        border-color: #E9E8E8;
    }
    .text {
        padding: 1%;
        color: #000000;
    }
    .waktu {
        float: right;
        margin-left: 5%;
    }
    .chat {
        float: left;
        margin-right: 5%;
        width: 90%;
    }
</style>

<p>
<div class="panel panel-default">
    <div class="panel-heading"><b><?= Html::encode($model->nama)?></b></div>
    <div class="panel-body">
        <div class="waktu">
            <?= Html::encode($model->waktu)?>
        </div>
        <div class="chat">
            <?= Html::encode($model->chat) ?>
        </div>
    </div>
</div>
</p>
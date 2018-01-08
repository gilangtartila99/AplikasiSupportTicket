<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="ticket-view">
    <center>
        <font size="7"><b>Welcome!</b></font>
        <br>
        <img src="images/logo.png" width="40%">
        <br>
        <font size="5"><b>Support Ticket System</b></font>
        <br>
        <?= Html::a('<p>'.Html::img("images/1.png", ['width' => '10%']).'</p>', Url::to(['login'])) ?>
    </center>
</div>

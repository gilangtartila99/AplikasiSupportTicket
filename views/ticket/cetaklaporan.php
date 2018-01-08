<?php
include '../config/db.php';

$sql = "SELECT COUNT(id_ticket) as ticket FROM ticket";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_assoc($result);

$sql2 = "SELECT COUNT(category.id_category) as category1 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Jaringan'";
$result2 = mysql_query($sql2) or die(mysql_error());
$row2 = mysql_fetch_assoc($result2);

$sql3 = "SELECT COUNT(category.id_category) as category2 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Bugs'";
$result3 = mysql_query($sql3) or die(mysql_error());
$row3 = mysql_fetch_assoc($result3);

$sql4 = "SELECT COUNT(category.id_category) as category3 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Technical Support'";
$result4 = mysql_query($sql4) or die(mysql_error());
$row4 = mysql_fetch_assoc($result4);

$sql5 = "SELECT COUNT(category.id_category) as category4 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Konsultasi'";
$result5 = mysql_query($sql5) or die(mysql_error());
$row5 = mysql_fetch_assoc($result5);

$sql6 = "SELECT COUNT(category.id_category) as category5 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Permintaan Data'";
$result6 = mysql_query($sql6) or die(mysql_error());
$row6 = mysql_fetch_assoc($result6);

$sql7 = "SELECT COUNT(category.id_category) as category6 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Human Error'";
$result7 = mysql_query($sql7) or die(mysql_error());
$row7 = mysql_fetch_assoc($result7);

$sql8 = "SELECT COUNT(category.id_category) as category7 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Gawean'";
$result8 = mysql_query($sql8) or die(mysql_error());
$row8 = mysql_fetch_assoc($result8);

/* @var $this yii\web\View */
use sjaakp\gcharts\LineChart;
use yii\grid\GridView;

?>
<style type="text/css">
    .jarak {
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .support {
        background-color: #5B5B5B;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .jaringan {
        background-color: #00A196;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .bugs {
        background-color: #005BA1;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .technical {
        background-color: #0016A1;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .konsultasi {
        background-color: #4100A1;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .permintaan {
        background-color: #00A176;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .human {
        background-color: #00A116;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }
    .gawean {
        background-color: #A19600;
        color: #fff;
        padding-top: 5px;
        padding-left: 5px;
        padding-bottom: 5px;
        padding-right: 5px;
    }

</style>
<div class="site-index">

    <p align="center">
        <font size="5"><b>Report Support Ticket</b></font>
    </p>

    <table width="100%" border="4">
        <?= LineChart::widget([
            'height' => '400px',
            'dataProvider' => $dataProvider2,
            'columns' => [
                'bulan:string',
                'jumlah'
            ],
            'options' => [
                'title' => 'Presentase Support Ticket'
            ],
        ]) ?>
    </table>

    <table width="100%" border="4">
        <tr align="center">
            <th width="50%" class="support" align="center">
                <font size="2"><b><u>Support Ticket</u></b></font>
            </th>
            <th width="50%" class="jaringan" align="center">
                <font size="2"><b><u>Jaringan</u></b></font>
            </th>
        </tr>
        <tr align="center">
            <td width="50%" class="support" align="center">
                <font size="3"><?php echo $row['ticket']; ?></font>
            </td>
            <td width="50%" class="jaringan" align="center">
                <font size="3"><?php echo $row2['category1']; ?></font>
            </td>
        </tr>
        <tr align="center">
            <th width="50%" class="bugs" align="center">
                <font size="2"><b><u>Bugs</u></b></font>
            </th>
            <th width="50%" class="technical" align="center">
                <font size="2"><b><u>Technical Support</u></b></font>
            </th>
        </tr>
        <tr align="center">
            <td width="50%" class="bugs" align="center">
                <font size="3"><?php echo $row3['category2']; ?></font>
            </td>
            <td width="50%" class="technical" align="center">
                <font size="3"><?php echo $row4['category3']; ?></font>
            </td>
        </tr>
    </table>

    <table width="100%" border="4">
        <tr align="center">
            <th width="50%" class="konsultasi" align="center">
                <font size="2"><b><u>Konsultasi</u></b></font>
            </th>
            <th width="50%" class="permintaan" align="center">
                <font size="2"><b><u>Permintaan Data</u></b></font>
            </th>
        </tr>
        <tr align="center">
            <td width="50%" class="konsultasi" align="center">
                <font size="3"><?php echo $row5['category4']; ?></font>
            </td>
            <td width="50%" class="permintaan" align="center">
                <font size="3"><?php echo $row6['category5']; ?></font>
            </td>
        </tr>
        <tr align="center">
            <th width="50%" class="human" align="center">
                <font size="2"><b><u>Human Error</u></b></font>
            </th>
            <th width="50%" class="gawean" align="center">
                <font size="2"><b><u>Gawean</u></b></font>
            </th>
        </tr>
        <tr align="center">
            <td width="50%" class="human" align="center">
                <font size="3"><?php echo $row7['category6']; ?></font>
            </td>
            <td width="50%" class="gawean" align="center">
                <font size="3"><?php echo $row8['category7']; ?></font>
            </td>
        </tr>
    </table>

    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'date',
            'subject',
            [
                'label' => 'Category',
                'attribute' => 'nama_category',
                'value' => 'category.nama_category'
            ],
            'state',
        ],
    ]); ?>

</div>

<?php
include '../config/db.php';

$sql = "SELECT COUNT(id_ticket) as ticket FROM ticket WHERE user_id=".Yii::$app->user->identity->id."";
$result = mysql_query($sql) or die(mysql_error());
$row = mysql_fetch_assoc($result);

$sql2 = "SELECT COUNT(category.id_category) as category1 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Jaringan' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result2 = mysql_query($sql2) or die(mysql_error());
$row2 = mysql_fetch_assoc($result2);

$sql3 = "SELECT COUNT(category.id_category) as category2 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Bugs' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result3 = mysql_query($sql3) or die(mysql_error());
$row3 = mysql_fetch_assoc($result3);

$sql4 = "SELECT COUNT(category.id_category) as category3 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Technical Support' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result4 = mysql_query($sql4) or die(mysql_error());
$row4 = mysql_fetch_assoc($result4);

$sql5 = "SELECT COUNT(category.id_category) as category4 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Konsultasi' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result5 = mysql_query($sql5) or die(mysql_error());
$row5 = mysql_fetch_assoc($result5);

$sql6 = "SELECT COUNT(category.id_category) as category5 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Permintaan Data' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result6 = mysql_query($sql6) or die(mysql_error());
$row6 = mysql_fetch_assoc($result6);

$sql7 = "SELECT COUNT(category.id_category) as category6 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Human Error' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result7 = mysql_query($sql7) or die(mysql_error());
$row7 = mysql_fetch_assoc($result7);

$sql8 = "SELECT COUNT(category.id_category) as category7 FROM ticket JOIN category ON ticket.category_id=category.id_category WHERE category.nama_category='Gawean' AND ticket.user_id=".Yii::$app->user->identity->id."";
$result8 = mysql_query($sql8) or die(mysql_error());
$row8 = mysql_fetch_assoc($result8);

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<style type="text/css">
	.jarak {
		padding-top: 2%;
		padding-left: 2%;
		padding-bottom: 2%;
		padding-right: 2%;
	}
	.support {
		background-color: #5B5B5B;
		color: #fff;
	}
	.jaringan {
		background-color: #00A196;
		color: #fff;
	}
	.bugs {
		background-color: #005BA1;
		color: #fff;
	}
	.technical {
		background-color: #0016A1;
		color: #fff;
	}
	.konsultasi {
		background-color: #4100A1;
		color: #fff;
	}
	.permintaan {
		background-color: #00A176;
		color: #fff;
	}
	.human {
		background-color: #00A116;
		color: #fff;
	}
	.gawean {
		background-color: #A19600;
		color: #fff;
	}

</style>
<div class="site-index">

	<div class="thumbnail col-xs-3 jarak support">
        <font size="5"><b><u>Support Ticket</u></b></font>
		<br>
        <font size="7"><?php echo $row['ticket']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak jaringan">
        <font size="5"><b><u>Jaringan</u></b></font>
		<br>
        <font size="7"><?php echo $row2['category1']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak bugs">
        <font size="5"><b><u>Bugs</u></b></font>
		<br>
        <font size="7"><?php echo $row3['category2']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak technical">
        <font size="5"><b><u>Technical Support</u></b></font>
		<br>
        <font size="7"><?php echo $row4['category3']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak konsultasi">
        <font size="5"><b><u>Konsultasi</u></b></font>
		<br>
        <font size="7"><?php echo $row5['category4']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak permintaan">
        <font size="5"><b><u>Permintaan Data</u></b></font>
		<br>
        <font size="7"><?php echo $row6['category5']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak human">
        <font size="5"><b><u>Human Error</u></b></font>
		<br>
        <font size="7"><?php echo $row7['category6']; ?></font>
	</div>

	<div class="thumbnail col-xs-3 jarak gawean">
        <font size="5"><b><u>Gawean</u></b></font>
		<br>
        <font size="7"><?php echo $row8['category7']; ?></font>
	</div>

</div>

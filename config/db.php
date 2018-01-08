<?php

mysql_connect('localhost','root','');
mysql_select_db('ticket');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=ticket',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];

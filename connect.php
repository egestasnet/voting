<?php
$SQL_host     = 'localhost';
$SQL_user     = 'username';
$SQL_password = 'password';
$SQL_database = 'voting';

$db = new MySQLi( $SQL_host, $SQL_user, $SQL_password, $SQL_database );
$db->set_charset("utf8mb4");
$db->query("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci");

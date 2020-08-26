<?php
$SQL_host     = '127.0.0.1:3307';
$SQL_user     = 'developer';
$SQL_password = 'Fraai_M0ment';
$SQL_database = 'voting';

$db = new MySQLi( $SQL_host, $SQL_user, $SQL_password, $SQL_database );
$db->set_charset("utf8mb4");
$db->query("SET NAMES utf8mb4 COLLATE utf8mb4_general_ci");

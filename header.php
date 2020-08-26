<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<title>Voting</title>

<meta name="viewport" content="user-scalable=1, width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0" />

<link rel="stylesheet" type="text/css" href="styles.css" />

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<style>
html {
	font-size: 13px;
	}

#container {
	width: 720px;
	padding: 1.000em;
	border: 0.100em solid red;
	margin: 1.000em auto;
	font-family: futura;
	font-size: 1.100em;
	}

table, th, td {
	border: 0.100em solid navy;
	border-collapse: collapse;
	}

table {
	width: 100%;
	}

th {
	text-align: left;
	background-color: #dcdc00;
	}

th:first-child {
	width: 20%;
	}

th, td {
	padding: 0.500em;
	}

tr:nth-child(odd) {
	background: #dcdcdc;
	}

tr:nth-child(even) {
	background: #dcdcaa;
	}

tr.afspraak {
	background: ivory;
	}

</style>

</head>

<body>

<div id='loginDiv'>
<?php include('menu.php'); ?>
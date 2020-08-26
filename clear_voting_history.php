<?php
include('connect.php');

if ( isset( $_GET['token'] ) AND $_GET['token'] <> '')
{
	$token = $_GET['token'];
	$query = "
DELETE b1 FROM voting_ballot b1
INNER JOIN voting_ballot b2 
WHERE
	b1.id < b2.id AND 
	b1.token = b2.token AND
	b1.token = '" . $token . "';
";
	$result = $db->query( $query );
}

header("location:vote.php?token=" . $token);
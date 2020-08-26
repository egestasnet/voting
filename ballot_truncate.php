<?php
include('connect.php');

$query = "TRUNCATE TABLE `voting_ballot`;";
$result = $db->query( $query );

header("location:ballot_result.php");
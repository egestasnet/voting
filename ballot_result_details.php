<?php
include('header.php');
?>
<pre>
# CLI COMMANDS IN PHPMYADMIN TO CHECK RESULTS
SELECT token, vote, datum, hash FROM voting_ballot ORDER BY token, datum;

CREATE TEMPORARY TABLE IF NOT EXISTS votingresult AS
(SELECT token, vote, MAX(datum) AS datum , COUNT(vote) AS 'count', hash FROM voting_ballot GROUP BY token DESC ORDER BY vote);

SELECT * FROM votingresult;

SELECT vote, COUNT(vote) AS 'count' FROM votingresult GROUP BY vote ORDER BY 'count' DESC, vote;

SELECT
( SELECT COUNT(*)    FROM voting_members ) AS members,
( SELECT COUNT(*)    FROM voting_tokens  ) AS tokens,
( SELECT COUNT(*)    FROM voting_ballot  ) AS totalvoted,
( SELECT COUNT(vote) FROM votingresult   ) AS ballot;
</pre>

<?php
include('connect.php');
?>

<h4>VOTING HISTORY</h4>

<?php
$query  = "SELECT token, vote, datum, hash FROM voting_ballot ORDER BY token, datum;";
$result = $db->query( $query );
//$rows = $result->fetch_all();
//echo '<pre>' . print_r( $rows, TRUE ) . '</pre>';
?>

<table border="1">
<thead>
	<tr>

<?php
$finfo = $result->fetch_fields();
foreach ( $finfo as $val )
{
	echo '<th>' . $val->name . '</th>' . PHP_EOL;
}
?>

	</tr>
</thead>

<?php
while ( $row = $result->fetch_object() )
{
	echo '<tr>';
	echo '<td>' . $row->token . '</td>';
	echo '<td>' . $row->vote  . '</td>';
	echo '<td>' . $row->datum . '</td>';
	echo '<td>' . $row->hash  . '</td>';
	echo '</tr>';
}
?>

</table>

<h4>CREATE TEMPORARY TABLE TO COUNT UNIQUE VOTES WITH HISTORY COUNT</h4>
<p>Temporary table results are not displayed</p>

<?php
$query = "CREATE TEMPORARY TABLE IF NOT EXISTS votingresult AS
(SELECT token, vote, max(datum) AS datum, count(vote) AS 'count', hash FROM voting_ballot GROUP BY token DESC ORDER BY vote);";
$result = $db->query( $query );
?>

<h4>SHOW THE DETAILED FINAL RESULT OF THE TEMPORARY RESULT</h4>
<p>The <b>count</b> number is the number of times a voter voted and/or changed his mind.<br />
Unless the voter cleared his voting history.<br />
Only the last vote is counted towards the final result.<br />
Compare with the <b>voting history</b> above.</p>

<?php
$query = "SELECT * FROM votingresult;";
$result = $db->query( $query );
//$rows = $result->fetch_all();
//echo '<pre>' . print_r( $rows, TRUE ) . '</pre>';
?>

<table border="1">
<thead>
	<tr>

<?php
$finfo = $result->fetch_fields();
foreach ( $finfo as $val )
{
	echo '<th>' . $val->name . '</th>' . PHP_EOL;
}
?>

	</tr>
</thead>

<?php
while ( $row = $result->fetch_object() )
{
	echo '<tr>';
	echo '<td>' . $row->token . '</td>';
	echo '<td>' . $row->vote  . '</td>';
	echo '<td>' . $row->datum . '</td>';
	echo '<td>' . $row->count . '</td>';
	echo '<td>' . $row->hash  . '</td>';
	echo '</tr>';
}
?>

</table>

<h4>AS BEFORE, JUST THE WINNERS + COUNT</h4>

<?php
$query = "SELECT vote, count(vote) AS 'count' FROM votingresult GROUP BY vote ORDER BY 'count' DESC, vote;";
$result = $db->query( $query );
//$rows = $result->fetch_all();
//echo '<pre>' . print_r( $rows, TRUE ) . '</pre>';
?>

<table border="1">
<thead>
	<tr>

<?php
$finfo = $result->fetch_fields();
foreach ( $finfo as $val )
{
	echo '<th>' . $val->name . '</th>' . PHP_EOL;
}
?>

	</tr>
</thead>

<?php
while ( $row = $result->fetch_object() )
{
	echo '<tr>';
	echo '<td>' . $row->vote  . '</td>';
	echo '<td>' . $row->count . '</td>';
	echo '</tr>';
}
?>

</table>

<h4>SUMMARY COUNT OF MEMBERS, TOKENS AND BALLOT</h4>
<p>Note that the <i>ballot</i> count should be less or equal to the <i>members</i> count.<br />
More <i>ballot</i> counts mean more <i>tokens</i> are used than <i>members</i>.<br />
Unless there is a list of <i>member &lt;==&gt; tokens</i>, there is <b>NO WAY</b> to know who was a real/fake voter.<br />
Solution : create fewer or equal numbers of tokens as there are members.</p>

<?php
$query = "SELECT
( SELECT count(*)    FROM voting_members ) AS members,
( SELECT count(*)    FROM voting_tokens  ) AS tokens,
( SELECT count(*)    FROM voting_ballot  ) AS totalvoted,
( SELECT count(vote) FROM votingresult   ) AS ballot;";
$result = $db->query( $query );
//$rows = $result->fetch_all();
//echo '<pre>' . print_r( $rows, TRUE ) . '</pre>';
?>

<table border="1">
<thead>
	<tr>

<?php
$finfo = $result->fetch_fields();
foreach ( $finfo as $val )
{
	echo '<th>' . $val->name . '</th>' . PHP_EOL;
}
?>

	</tr>
</thead>

<?php
while ( $row = $result->fetch_object() )
{
	echo '<tr>';
	echo '<td>' . $row->members . '</td>';
	echo '<td>' . $row->tokens  . '</td>';
	echo '<td>' . $row->totalvoted . '</td>';
	echo '<td>' . $row->ballot . '</td>';
	echo '</tr>';
}
?>

</table>

<?php
include('footer.php');
?>
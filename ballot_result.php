<?php
include("header.php");

$_POST['select'] = 'Voting result';

include('connect.php');

$query = "CREATE TEMPORARY TABLE IF NOT EXISTS votingresult AS
(SELECT token, vote, max(datum) , count(vote), hash FROM voting_ballot group by token DESC order by vote);";
$result = $db->query( $query );

$query = "SELECT vote, count(vote) AS aantal FROM votingresult GROUP BY vote ORDER BY aantal DESC, vote;";
$result = $db->query( $query );

?>
<table border="1">
<caption>Result for <b><?php echo $_POST['select']; ?></b><caption>
<thead>
	<tr>
	<?php
	$finfo = $result->fetch_fields();
	foreach ( $finfo as $val )
	{
		echo '<th>' . $val->name . '</th>' . PHP_EOL;
	}
	?>
	<th></th>
	</tr>
</thead>
<tbody>

<?php
while ( $row = $result->fetch_object() )
{
	?>

	<tr>
		<td><?php echo $row->vote; ?></td>
		<td><code><?php echo $row->aantal; ?></code></td>
		<td><img src="OurTeam-<?php echo $row->vote; ?>.jpg" style="width:50px;"></td>
	</tr>

	<?php
}
?>

</tbody>
</table>

<hr />

<button style="font-size:110%"><a href="show_tokens.php" style="text-decoration: none;">Get new token</a></button>

<?php
include("footer.php");
?>
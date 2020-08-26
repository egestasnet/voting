<?php
include("header.php");

$_POST['select'] = 'Tokens';

include('connect.php');
?>

<table border="1">

<caption>Resultaat voor <b><?php echo $_POST['select']; ?></b><caption>

<?php
$query = "SELECT
	id,
	token
FROM
	voting_tokens
ORDER BY id";

$result = $db->query( $query );
?>
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

<tbody>
<?php
while ( $row = $result->fetch_object() )
{
	$link = 'vote.php?token=' . $row->token;
	?>
	<tr>
		<td><code><?php echo $row->id; ?></code></td>
		<td><code><a href="<?php echo $link; ?>"><?php echo $row->token; ?></a></code></td>
	</tr>
	<?php
}
?>

</tbody>
</table>

<?php
include("footer.php");
?>
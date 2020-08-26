<?php
include("header.php");
?>

<?php
if ( isset( $_POST['submit'] ) && isset( $_POST['token'] ) == 'true' )
{
	include('connect.php');
	$query = "TRUNCATE TABLE `voting_tokens`;";
	$result = $db->query( $query );

	function GUID( $num )
	{
		return bin2hex( openssl_random_pseudo_bytes( $num ) );
	}

	$count = 10;
	$token = GUID( $count );
	$numberoftokens = (int)$_POST['numberoftokens'];

	echo '<pre>';
	for ( $i = 0; $i < $numberoftokens; $i++ )
	{
		$t = GUID( $count );
		echo '("' . $t . '"),<br />';
		$query = "INSERT INTO voting_tokens (token) VALUES ('" . $t . "')";
		$result = $db->query( $query );
	}
	echo '</pre>';

?>

	<p><a href="vote_create_token.php">Create new tokens</a></p>
	<p><a href="show_tokens.php">Get new token from database</a></p>

<?php
}
?>

<h3>This truncates the <i>voting_tokens</i> table and creates new tokens.</h3>

<form method="post">
	<input type="hidden" name="token" value="true" />
	Number of tokens <input type="number" name="numberoftokens" value="" /><br />
	<button type="submit" name="submit" style="font-size:110%">Empty table and add new tokens</button>
</form>

<?php
include("footer.php");
?>
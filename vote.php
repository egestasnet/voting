<?php
include("header.php");
include('connect.php');

if ( isset( $_POST['vote'] ) )
{
	if ( $_POST['candidate'] <> '' )
	{
		$candidate = $db->real_escape_string($_POST['candidate']);
		$candidateexists = FALSE;
		$query = "SELECT candidate_name FROM voting_candidates WHERE candidate_name = '" . $candidate . "'";
		$result = $db->query( $query );
		if ( $result->num_rows )
		{
			$datum = date('Y-m-d H:i:s');
			$votehash = md5( $_POST['token'] . $_POST['candidate'] . $datum );
			$query = "INSERT INTO voting_ballot ( token, vote, datum, hash ) VALUES ( '" . $_POST['token'] . "','" . $_POST['candidate'] . "','" . $datum . "','" . $votehash . "')";
			$result = $db->query( $query );
			if ( $result )
			{
				echo '<h1>Vote added</h1>';
			} else {
				echo '<h1>Something went wrong</h1>';
			}
		} else {
			echo '<h1>Candidate does not exist</h1>';
		}
	} else {
		echo '<h1>No candidate selected</h1>';
	}
	echo '<hr />';
}
if ( isset( $_GET['token'] ) )
{
	if ( $_GET['token'] != '' )
	{
		$tokenexist = TRUE;
		$query = "SELECT token FROM voting_tokens WHERE token = '" . $_GET['token'] . "'";
		$result = $db->query( $query );
		if ( !$result->num_rows ) {
			$tokenexist = FALSE;
		}
		if ( $tokenexist )
		{
			$gettoken = $_GET['token'];

?>

<style>
#OurTeam {
	width: 100%;
	height: auto;
	overflow: hidden;
	padding: 1.000em;
	margin: 1.000em auto;
	font-family: futura;
	font-size: 1.100em;
}

figure {
	width: 94px;
	float: left;
	margin: 0.500em;
}
figure img {
	width: 100%;
}

figure figcaption {
	text-align: center;
}

</style>

<table border="1">
	<caption><h4>Votehistory of token <b><?php echo $gettoken; ?></b></h4><caption>

<?php

// stem historie per token
$query = "
SELECT
	b.id, b.token, b.vote, b.datum
FROM
	voting_ballot b
JOIN
	voting_tokens t
ON
	t.token = b.token
WHERE
	b.token = '" . $gettoken . "'
ORDER BY
	b.token, b.datum;
";
$result = $db->query( $query );
?>
<thead>
	<tr>
	<?php
	$finfo = $result->fetch_fields();
	foreach ( $finfo as $val )
	{
		echo '<th>' . ucfirst( $val->name ) . '</th>' . PHP_EOL;
	}
	?>
	</tr>
</thead>

<tbody>
<?php
while ( $row = $result->fetch_object() )
{
	echo '<tr>
	<td><code>' . $row->id    . '</code></td>
	<td><code>' . $row->token . '</code></td>
	<td><code>' . $row->vote  . '</code></td>
	<td><code>' . $row->datum . '</code></td></tr>';
}
?>

</tbody>
</table>

<h3>Our Team</h3>

<form method="post" action="">

<input type="hidden" name="token" value="<?php echo $gettoken; ?>" />

<div id="OurTeam">

<?php
$query = "SELECT * FROM voting_candidates;";
$result = $db->query( $query );
if ( $result->num_rows )
{
	while ( $row = $result->fetch_object() )
	{
	?>

<figure>
<label for="<?php echo $row->candidate_name; ?>"><img src="OurTeam-<?php echo $row->candidate_name; ?>.jpg" /></label>
<figcaption><input type="radio" id="<?php echo $row->candidate_name; ?>" name="candidate" value="<?php echo $row->candidate_name; ?>" /><?php echo $row->candidate_name; ?></figcaption>
</figure>

	<?php
	}
} else {
	echo '<h3>No candidates in database</h3>';
}
?>

</div>

<button type="submit" name="vote" style="font-size:120%; margin: 1.000em auto;">Submit your vote</button>

</form>

<hr />

<button style="font-size:110%"><a href="members.php" style="text-decoration: none;">Get new token</a></button>

<button style="font-size:110%;"><a href="ballot_result.php" style="text-decoration: none;">Result</a></button>

<button style="font-size:110%;"><a href="clear_voting_history.php?token=<?php echo $gettoken; ?>" style="text-decoration: none;">Clear your votinghistory</a></button>

<button style="font-size:110%;" onclick="window.close();">Close browserwindow</button>

<?php
		} else {
			echo '<p>Token is wrong.</p>';
			echo '<p>Click <a href="members.php">the link in the e-mailmessage</a> again.</p>';
		}
	} else {
		echo '<p>Info missing</p>';
		echo '<p>Click <a href="members.php">the link in the e-mailmessage</a> again.</p>';
	}
} else {
	echo '<p>Info missing</p>';
	echo '<p>Click <a href="members.php">the link in the e-mailmessage</a> again.</p>';
}
?>

<?php
include("footer.php");
?>
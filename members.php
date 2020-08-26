<?php
include("header.php");
include('connect.php');

$_POST['select'] = 'Members';

// PRE MySQL 8.0
// https://www.mysqltutorial.org/mysql-row_number/
$MySQL8 = FALSE;

if ( $MySQL8 )
{
	// BEGIN MySQL 8.0 > RELOADING PAGE WILL SHOW RANDOM TOKENS
	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS memberslist AS
(select ROW_NUMBER() OVER (ORDER BY rand()) AS m_row_num, id, name, email from voting_members );";

	$result = $db->query( $query );

	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS tokenlist AS
(select ROW_NUMBER() OVER (ORDER BY rand()) AS t_row_num, id, token from voting_tokens );";

	$result = $db->query( $query );
	// END MySQL 8.0 >

} else {

	// BEGIN PRE MYSQL 8.0 RELOADING PAGE WILL SHOW SAME TOKENS
	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS memberslist AS
(SELECT (@row_number:=@row_number + 1) AS m_row_num, id, name, email FROM voting_members, (SELECT @row_number:=0) AS t );";

	$result = $db->query( $query );

	$query = "CREATE TEMPORARY TABLE IF NOT EXISTS tokenlist AS
(SELECT (@row_number:=@row_number + 1) AS t_row_num, id, token FROM voting_tokens, (SELECT @row_number:=0) AS t );";

	$result = $db->query( $query );
	// END PRE MYSQL 8.0
}

$query = "SELECT m.id AS memberid, m.name, m.email, t.token
FROM memberslist m
JOIN tokenlist t
ON m_row_num = t_row_num
ORDER BY memberid;";

$result = $db->query( $query );
// END
?>

<h3>Sample mailinglist</h3>
<p>Example shows how each member receives a random unique token.</p>
<p>Member receives token by e-mail.</p>
<p>As long as the ballotbox is open, voting and changing a vote is possible.</p>
<p>The last submitted vote is counted.</p>
<p>The list should only be send ONCE.<br />
Otherwise a member might receive a token from another member.</p>

<p>Membernames and e-mail from <a href="https://www.fakenamegenerator.com/" target="_blank">Fakename Generator</a></p>

<p><a href="Ideeën om te stemmen in een vereniging of club.pdf" target="_blank">Ideeën om te stemmen in een vereniging of club (Dutch)</a></p>

<table border="1">
<caption>Results for <b><?php echo $_POST['select']; ?></b><caption>
<thead>
	<tr>
	<th>Member ID</th>
	<th>Name/e-mail</th>
	<th>Token to vote</th>
	</tr>
</thead>

<tbody>
	<tr><td colspan="3" style="background-color: white;"></td></tr>
<?php
while ( $row = $result->fetch_object() )
{
?>
	<tr>
		<td><code><?php echo $row->memberid; ?></code></td>
		<td><?php echo $row->name; ?><br />
		<code><?php echo $row->email; ?></code></td>
		<td><a href="vote.php?token=<?php echo $row->token; ?>" target="_blank"><?php echo $row->token; ?></a></td>
	</tr>
	<tr>
		<td colspan="3">If the link does not work, copy the link below and paste it in the addressfield of the browser.<br />
		<?php echo $_SERVER["HTTP_HOST"] .  dirname($_SERVER["SCRIPT_NAME"]) . '/vote.php?token=' . $row->token; ?></td>
	</tr>
	<tr>
		<td colspan="3" style="background-color: white;"></td>
	</tr>
<?php
}
?>

</tbody>

</table>

<?php
include('footer.php');
?>
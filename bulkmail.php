<?php
include("header.php");
?>

<h3>Swift Mailer Script</h3>

<p>The script assumes the use of <a href="https://swiftmailer.symfony.com/docs/introduction.html" target="_blank">Swift Mailer</a> (not included).</p>

<p>The script is based on <a href="https://swiftmailer.symfony.com/docs/sending.html#sending-emails-in-batch" target="_blank">this code from the manual</a>.</p>

<p>In the script you can choose output to screen (for testing) OR to Swift Mailer.</p>

<hr style="border: 2px double red;"/>

<?php
include('connect.php');

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

$outputToSwiftmailer = FALSE; // FALSE IS TO SCREEN
$sendFromAddress     = 'info@eyourdomain.info';
$sendFromName        = 'The Administrator';
$votingPage          = 'vote.php?token=';
$voteurl             = $_SERVER["HTTP_HOST"] .  dirname($_SERVER["SCRIPT_NAME"]) . '/' . $votingPage;

if ( $outputToSwiftmailer )
{
	// START MAILING
	// Use this to actually send mail
	include_once 'lib/swift_required.php';
	// Create the Mailer using your created Transport
	$transport = Swift_MailTransport::newInstance();
	$mailer    = Swift_Mailer::newInstance($transport);
	$message = (new Swift_Message('Stemmen'))
->setFrom([$sendFromAddress => $sendFromName])
	;
} else {
	$message = (object)[]; // USED FOR OUTPUT TO SCREEN
	$message->setFrom = [$sendFromAddress => $sendFromName];
}

$to = []; // FOR DISPLAY PURPOSES LATER
while ( $row = $result->fetch_object() )
{
	$to[] = ['name' => $row->name, 'address' => $row->email, 'token' => $row->token]; // FOR DISPLAY PURPOSES LATER

	$name = htmlentities( $row->name );
	if ( $name == '')
	{
		$name = 'Dear member';
	}
	$address  = $row->email;
	$votelink = $voteurl . $row->token;
	$votehref = '<a href="' . $votingPage . $row->token . '">' . $votelink . '</a>';

	if ( $outputToSwiftmailer )
	{

		// BEGIN This is the code for SwiftMailer
		$bodyHTML  = "Hallo <b>" . $name . "</b>,<br />\r\n<br />\r\n
		Here's your personal token to vote.<br />\r\n<br />\r\n" . $votelink;
		$bodyPlainText = "Hallo " . $name . ",\r\n\r\n
		Here's your personal token to vote.\r\n\r\n" . $votelink;

		$message->setTo([$address => $name]);
		$message->setBody( $bodyHTML, 'text/html');
		$message->addPart( $bodyPlainText );
		$numSent += $mailer->send( $message, $failedRecipients );
		// END This is the code for SwiftMailer

	} else {

		// BEGIN DISPLAY $message ARRAY. FOR TEST PURPOSES
		$bodyHTML  = "Hallo <b>" . $name . "</b>,<br />\r\n<br />\r\n
		Here's your personal token to vote.<br />\r\n<br />\r\n" . $votehref;
		$bodyPlainText = "Hallo " . $name . ",\r\n\r\n
		Here's your personal token to vote.\r\n\r\n" . $votelink;

		$message->setTo   = [$address => $name];
		$message->setBody = $bodyHTML;
		$message->addPart = $bodyPlainText;
		echo '<pre>' . print_r( $message, TRUE ) . '</pre>';
		$numSent++;
		// END DISPLAY $message ARRAY

	}
}

echo '<pre>' . print_r( $to, TRUE ) . '</pre>'; // FOR DISPLAY PURPOSES

printf("<p>Sent %d messages</p>\n", $numSent);

?>

<?php
include('footer.php');
?>
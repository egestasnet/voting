<?php
include("header.php");

function GUID( $num )
{
	return bin2hex( openssl_random_pseudo_bytes( $num ) );
}

$count = 10;
$token = GUID( $count );

echo '<p>$token = <b>' . $token . '</b><br />';
echo '<pre>';
for ( $i = 0; $i < 100; $i++ )
{
	$t = GUID( $count );
	//echo '$token = <b>"' . $t . '"</b><br />';
	echo '("' . $t . '"),<br />';
}
echo '</pre>';
?>

<p><a href="vote.php?token=<?php echo $token; ?>">Cast your vote</a></p>

<p><a href="vote_create_token.php">Create new token</a></p>

<p><a href="show_tokens.php">Get new token from database</a></p>

<?php
// om bestand te vullen

$sql = "INSERT INTO voting_tokens (token) VALUES
('" . $token . ")";

$sql = 'INSERT INTO tokens (token) VALUES
("f6790150e5e7b0b5ba55"),
("eed434f985a33cb762ca"),
("24e797c21f8bfbd32b84"),
("ee5321ad1e67f7a0eb87"),
("6d4a711c3df026168635"),
("0a5f4370a13f8c45c17f"),
("40e2cdc8c1fc68da5bcf"),
("bb085e87fc8a161304b3"),
("1415a2ae527bdad0c04d"),
("45afa17887c7656e1b5a"),
("f8a6499636fca534c157"),
("ff2246203cbdecce80d6"),
("d604de822b0f391e44b4"),
("c17ab9d24b4f22c4b557"),
("88e2e0b2e5709dd48403"),
("5ae976ee03e02e8b7bca"),
("fdaeb77d35d7e50c45d8"),
("5a5efe9f7da57daf2af3"),
("8a327c0f42edcbc03faf"),
("64198b9d40e53869fafe"),
("eb01858a76f72bf1fe77"),
("b834ea19fb999ddd2168"),
("faba20f0dda399152b4d"),
("c4911ef755830635a723"),
("0923fc9405db3b84c326"),
("e4de8885c50343db856d"),
("3aa97aa79d937219f6c8"),
("f7795a4a6d106f82f3ba"),
("7780fd110bfc183d3ce4"),
("8d6e5d4d269c629746c7"),
("44a79d2f405bf764ea2a"),
("64941fe0df393487e21d"),
("3c21f70419e1a7428dc0"),
("049e6fc1d02d95bb37eb"),
("28fd10d796155801df49"),
("3aeaa95f842b7a1f7077"),
("726e662b8106f34c2a32"),
("344f48c4d5336b1ba6fe"),
("0264a3f3d289ab82f056"),
("b5c61bfc7cb973c22d36"),
("41ede69b59e350b175df"),
("a2894a44d5015ce88dcd"),
("8116c11f32661e13622a"),
("71a75c00439acc04190c"),
("e0d8ac4d0c1e01044953"),
("a9b305a1afa19b2d8daa"),
("326ba4f9a645f621434b"),
("6b669d973d1a23342b77"),
("1f954386e7443992d715"),
("59657f350c827ba834b8"),
("db19658752143f84308e"),
("c49967bcdad511690bb6"),
("1f9ec0cfb89a11d1bc0a"),
("24a41a96d06e6fe4b32c"),
("d5a5a8b0d00762e790ea"),
("0755ad81643f2baab003"),
("d1acb64299d7985b007e"),
("363b2577f2a3afbc41d2"),
("53db366c56ac23152b33"),
("a1d1de3ef45925a6347b"),
("7ac5e72902f059a2b8ec"),
("4b781e75b3878b645f57"),
("597161d97428160cb1a5"),
("a72b988454dc79e490f6"),
("18e2ec009c3985c2c762"),
("c621dc1eb238d8241237"),
("de0e17d3ff7708f9a5b2"),
("fc63edb67dabbb3188ab"),
("f52ff5828f0e32006ba9"),
("e5959aa10a9ffb539639"),
("c05e0184a3a7e3776e97"),
("ff0925a42b2ed86065a5"),
("740160b581fdc4f476d8"),
("f4059ca504030fdc07a5"),
("a5a365b0b4e34eee64da"),
("f2d3c5044d3e1ff1e6e7"),
("cc294c46bf24d989646b"),
("09c67d9241c0d20d465d"),
("a5ba9729f0fef0d84acf"),
("19dd8e197c5b65112d12"),
("cba8fe2f7074692b96f9"),
("26f9183ab0e0a9abbb5f"),
("10b50aabbd3cef519efa"),
("2c0ed2f4c38ea40bb856"),
("af5fa9d932a11a5d22f0"),
("b3093620f30468cbe4ac"),
("4a67fbb0162dae9d5cb4"),
("09359f5072cfd251960c"),
("f9051371030d638b1129"),
("228daf9858eb4e91fa87"),
("4d7c8ea6eb6a00f7450f"),
("1983529b744d82fc7ed7"),
("8a0c65106c18357d760d"),
("bd10f6168eb51b6e0349"),
("994372200e795ff75d43"),
("7fee3aa6efdfd0f8513c"),
("21bdf1c1e6981fc2c1ad"),
("136eb36b2cb8fd80d5e2"),
("253330a0e91d999a1b17"),
("f72d48c349024b1eb150");
';
?>

<?php
include("footer.php");
?>
<?php
	require_once("internet/website/php/namespace/application/segment.php");

	use application\segment as applicationSegment;
?>

<?php
	$webpage = new applicationSegment\webpage(
		"iceKnives32",
		"utf-8",
		['name="viewport" content="width=device-width, initial-scale=1"'],
		["internet/website/css/iceKnives32/style.css"],
		[],
		"Asia/Kolkata"
	);
	echo $webpage->head();
?>

<?php
	echo "Hello World!";
	echo "<br>";
?>

<?php
	echo $webpage->time();
	echo $webpage->foot();
?>
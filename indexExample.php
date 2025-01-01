<?php
	require_once("internet/website/php/namespace/html/segment.php");

	use html\segment as htmlSegment;
?>

<?php
	$website = new htmlSegment\website(
		"iceKnives32",
		"utf-8",
		['name="viewport" content="width=device-width, initial-scale=1"'],
		["internet/website/css/style.css"],
		[],
		"Asia/Kolkata"
	);
	echo $website->head();
?>

<?php
	echo "Hello World!";
	echo "<br>";
?>

<?php
	echo $website->time();
	echo $website->foot();
?>
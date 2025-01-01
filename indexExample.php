<?php
	require_once("internet/website/php/namespace/application/segment.php");
	require_once("internet/website/php/namespace/library/memory/unit/associative/range.php");

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
	echo "Hello World! It's " . $webpage->time() . ".";
	echo "<br><hr><br><br>";

	// Following space can be used for R&D at developmet.
	$t = new library\memory\unit\associative\range(["acco", "unt"]);
	echo $t->count();
?>

<?php
	echo $webpage->foot();
?>
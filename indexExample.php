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
	echo "Hello World! It's " . $webpage->time() . ".<br>";
	echo "<br><br>";

	// Following space can be used for R&D at development.
	echo "-Example(s)-<br>";
	echo "<ul>";

	echo "<li>";
	echo "library\memory\unit\associative\\range() [class]<br>";
	$t = new library\memory\unit\associative\range([25, "foo", "bar", null, "set", true, 1.7]);
	echo "<br>Value: "; print_r($t->value());
	echo "<br>Count: " . $t->count();
	echo "<br>First data: " . $t->first();
	echo "<br>Last data: " . $t->last();
	$t->add("net");
	echo "<br>Value: "; print_r($t->value());
	echo "<br>Count: " . $t->count();
	$t->add("top", 8);
	echo "<br>Value: "; print_r($t->value());
	echo "<br>Count: " . $t->count();
	echo "<br>";
	$t = new library\memory\unit\associative\range(["foo" => ["lorem", "ipsum"], "bar"]);
	echo "<br>Value: "; print_r($t->value());
	echo "<br>Count: " . $t->count();
	echo "</li>";

	echo "</ul>";
	echo "<br><br>";
?>

<?php
	echo $webpage->foot();
?>
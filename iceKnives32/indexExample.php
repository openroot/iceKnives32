<?php
	require_once("internet/website/php/application/segment.php");
	require_once("internet/website/php/library/memory/packet/associative/range.php");

	use internet\website\php\application\segment as applicationSegment;
?>

<?php
	$webpage = new applicationSegment\webpage(
		"A website made with PHP",
		"utf-8",
		['name="viewport" content="width=device-width, initial-scale=1"'],
		["internet/website/css/style.css"],
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
	echo "[class] library\memory\packet\associative\\range()<br>";
	$t = new internet\website\php\library\memory\packet\associative\range([25, "foo", "bar", null, "set", true, 1.7]);
	echo "<br>[property] source: "; print_r($t->source);
	echo "<br>[property] count: " . $t->count;
	echo "<br>[function] first(): " . $t->first();
	echo "<br>[function] last(): " . $t->last();
	$t->add("net");
	echo "<br>[property] source: "; print_r($t->source);
	echo "<br>[property] count: " . $t->count;
	$t->add("top", 8);
	echo "<br>[property] source: "; print_r($t->source);
	echo "<br>[property] count: " . $t->count;
	echo "<br>";
	$t = new internet\website\php\library\memory\packet\associative\range(["foo" => ["lorem", "ipsum"], "bar"]);
	echo "<br>[property] source: "; print_r($t->source);
	echo "<br>[property] count: " . $t->count;
	echo "</li>";

	echo "</ul>";
	echo "<br><br>";
?>

<?php
	echo $webpage->foot();
?>
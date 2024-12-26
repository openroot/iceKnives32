<?php
	$data = file("32.txt");
	$grid = [];
	for ($i = 0; $i <= 25; $i++) {
		for ($j = 0; $j <= 25; $j++) {
			$grid[$i][$j] = trim($data[($j * 26) + $i]);
		}
	}

	echo "<pre>";

	echo "<table>";
	foreach ($grid as $row) {
		echo "<tr>";
		foreach ($row as $column) {
			echo "<td>";
			echo $column;
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";

	echo "</pre>";
?>
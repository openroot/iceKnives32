<?php
	$raw = file("32.txt");

	$data = [];
	$i = 0;
	foreach ($raw as $key) {
		$data[$i++] = trim($key);
	}

	$grid = [];
	for ($i = 0; $i <= 25; $i++) {
		for ($j = 0; $j <= 25; $j++) {
			$grid[$i][$j] = $data[($j * 26) + $i];
		}
	}

	echo "<pre>";

	echo "<table>";
	echo "<tr>";
	for ($k = 0; $k <= 26; $k++) {
		echo "<td>" . $k . "</td>";
	}
	echo "</tr>";
	$i = 1;
	foreach ($grid as $row) {
		echo "<tr>";
		echo "<td>" . $i++ . "</td>";
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
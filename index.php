<?php
	/*
	*/
	$raw = file("32.txt");

	/*
	*/
	$filter = [];
	$i = 0;
	foreach ($raw as $key) {
		$filter[$i++] = trim($key);
	}

	/*
	*/
	$data = [];
	$position = 1;
	foreach ($filter as $key) {
		$characters = str_split($key);
		$noncharacterCount = 0;
		foreach ($characters as $character) {
			//echo $character . ";";
		}
		$data[$key] = [
			"position_numeric" => $position++,
			"character_length" => strlen($key),
			"noncharacter_count" => $noncharacterCount
		];
	}

	/*
	*/
	$grid = [];
	for ($i = 0; $i <= 25; $i++) {
		for ($j = 0; $j <= 25; $j++) {
			$grid[$i][$j] = $filter[($j * 26) + $i];
		}
	}

	/*
	*/
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

	//
	print_r($data);

	echo "</pre>";
?>
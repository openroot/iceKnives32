<!DOCTYPE html>
<html lang="en">
	<head>
		<title>iceKnives32</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="style.css">
		<script src=""></script>
	</head>
	<body>

<?php
	/*
	*/
	$letterCodes = [
		"a" => 3, "b" => 2, "c" => 3, "d" => 3, "e" => 3, "f" => 5, "g" => 3, "h" => 4, "i" => 3, "j" => 5, "k" => 5, "l" => 7, "m" => 5, "n" => 5, "o" => 5, "p" => 5, "q" => 4, "r" => 4, "s" => 5, "t" => 3, "u" => 5, "v" => 2, "w" => 7, "x" => 1, "y" => 6, "z" => 6,
		"A" => 3, "B" => 2, "C" => 3, "D" => 3, "E" => 3, "F" => 5, "G" => 3, "H" => 4, "I" => 3, "J" => 5, "K" => 5, "L" => 7, "M" => 5, "N" => 5, "O" => 5, "P" => 5, "Q" => 4, "R" => 4, "S" => 5, "T" => 3, "U" => 5, "V" => 2, "W" => 7, "X" => 1, "Y" => 6, "Z" => 6
	];

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
		$checkKey = 0;
		foreach ($characters as $character) {
			if (!array_key_exists($character, $letterCodes)) {
				$noncharacterCount++;
			}
			else {
				$checkKey += $letterCodes[$character];
			}
		}
		$data[$key] = [
			"position_numeric" => $position++,
			"character_length" => strlen($key),
			"noncharacter_count" => $noncharacterCount,
			"check_key" => $checkKey
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
?>

<?php
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
			echo "<br>";
			echo "(" . $data[$column]["position_numeric"] . ") " . "[" . $data[$column]["character_length"] . "] " . "<" . $data[$column]["check_key"] . ">";
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</table>";

	/*print_r($data);
	$checkTotal = 0;
	foreach ($data as $key => $information) {
		$checkTotal += $information["check_key"];
	}
	echo "Check total: " . $checkTotal;*/

	echo "</pre>";
?>

	</body>
</html>
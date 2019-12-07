<?php
[$lowerLimit, $upperLimit] = array_map(function (string $value) {
    return intval($value);
}, explode('-', trim(file_get_contents('./inputs/day4.txt'))));

$validPasswords = [];
for ($password = $lowerLimit; $password <= $upperLimit; $password++) {
    $passwordString = (string) $password;

    $hasTwoAdjacents = false;
    $numbersDecrease = false;
    for ($i = 0; $i < strlen($passwordString); $i++) {
        if ($passwordString[$i] === ($passwordString[$i+1] ?? null)) {
            $hasTwoAdjacents = true;
        }

        if (isset($passwordString[$i+1]) && intval($passwordString[$i+1]) < intval($passwordString[$i])) {
            $numbersDecrease = true;
        }
    }

    if ($hasTwoAdjacents && !$numbersDecrease) {
        $validPasswords[] = $password;
    }
}

$sample = $validPasswords;
shuffle($sample);
var_dump('Here are some examples of valid passwords:');
var_dump(implode(', ', array_slice($sample, 0, 10)));
var_dump('Total of different passwords: ' . count($validPasswords));
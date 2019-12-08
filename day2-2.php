<?php
function calc(array &$inputsArray)
{
    for ($i = 0; isset($inputsArray[($i + 4)]); $i += 4) {
        $opcode = intval($inputsArray[$i]);

        if ($opcode === 99 || !in_array($opcode, [1,2])) {
            break;
        }

        $index1      = $inputsArray[$i+1];
        $index2      = $inputsArray[$i+2];
        $indexTarget = $inputsArray[$i+3];

        $value1 = $inputsArray[$index1];
        $value2 = $inputsArray[$index2];

        if ($opcode === 1) {
            $inputsArray[$indexTarget] = $value1 + $value2;
        }

        if ($opcode === 2) {
            $inputsArray[$indexTarget] = $value1 * $value2;
        }
    }
}

$originalInputs = trim(file_get_contents('./inputs/day2.txt'));

$limit = 100;
for ($noun = 0; $noun <= $limit; $noun++) {
    for($verb = 0; $verb <= $limit; $verb++) {
        $inputsArray = explode(',', $originalInputs);
        $inputsArray[1] = $noun;
        $inputsArray[2] = $verb;

        calc($inputsArray);

        if ($inputsArray[0] == 19690720) {
            var_dump($noun);
            var_dump($verb);
            var_dump("The answer is: " . (100 * $noun + $verb));
            exit;
        }
    }
}

var_dump("nothing found :( increase the limit ($limit)");
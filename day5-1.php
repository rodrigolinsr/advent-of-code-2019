<?php
function getOpcode(string $fullOpcode): int
{
    return substr($fullOpcode, -2);
}

function getParamMode(string $fullOpcode, int $paramPosition): int
{
    $arrayOpcode = array_reverse(str_split(substr($fullOpcode, 0, -2)));

    if (!isset($arrayOpcode[$paramPosition]) || empty($arrayOpcode[$paramPosition])) {
        return 0;
    }

    return $arrayOpcode[$paramPosition];
}

function calc(array &$inputsArray)
{
    $increasesByOpcode = [
        1 => 4,
        2 => 4,
        3 => 2,
        4 => 2,
    ];

    $firstOpcode = getOpcode($inputsArray[0]) ?? null;
    if (!$firstOpcode) {
        throw new \Exception('First Opcode not found');
    }

    $increase = $increasesByOpcode[$firstOpcode] ?? null;
    if (!$increase) {
        throw new \Exception('First opcode not valid: ' . $firstOpcode);
    }

    for ($i = 0; isset($inputsArray[$increase]); $i += $increase) {
        $firstField = $inputsArray[$i];
        $opcode     = getOpcode($firstField);

        if ($opcode === 99) {
            echo "Opcode 99: Program halted.\n";
            break;
        }

        if (!in_array($opcode, [1,2,3,4])) {
            throw new \Exception('Opcode not valid: ' . $opcode);
        }

        $param1     = &$inputsArray[$i+1];
        $paramMode1 = getParamMode($firstField, 0);

        if (in_array($opcode, [1,2])) {
            if ($paramMode1 === 0) {
                $value1 = $inputsArray[$param1];
            } else {
                $value1 = $param1;
            }

            $param2     = &$inputsArray[$i+2];
            $paramMode2 = getParamMode($firstField, 1);
            if ($paramMode2 === 0) {
                $value2 = $inputsArray[$param2];
            } else {
                $value2 = $param2;
            }

            $param3     = &$inputsArray[$i+3];
            $paramMode3 = getParamMode($firstField, 2);

            if ($paramMode3 !== 0) {
                throw new \Exception('Invalid parameter mode for writing.');
            }

            if ($opcode === 1) {
                $inputsArray[$param3] = $value1 + $value2;

            }

            if ($opcode === 2) {
                $inputsArray[$param3] = $value1 * $value2;
            }
        } else { // 3 or 4
            if ($opcode === 3) {
                echo "Inform the *input*: ";
                $handle = fopen ("php://stdin","r");
                $line = fgets($handle);

                $input = trim($line);

                if ($paramMode1 !== 0) {
                    throw new \Exception('Invalid parameter mode for writing.');
                }

                $inputsArray[$param1] = $input;
            }

            if ($opcode === 4) {
                if ($paramMode1 === 0) {
                    $outputValue = $inputsArray[$param1];
                } else {
                    $outputValue = $param1;
                }

                echo "Output instruction: $outputValue\n";
            }
        }

        $increase = $increasesByOpcode[$opcode];
    }
}

$originalInputs = trim(file_get_contents('./inputs/day5.txt'));
$inputsArray    = explode(',', $originalInputs);

calc($inputsArray);
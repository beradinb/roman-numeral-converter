<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConverterController extends Controller
{
    // Look up array of Roman numerals and their corresponding integer values
    protected $romanNumerals = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    /**
     * Convert the input to either Roman numeral or integer based on the input type.
     *
     * @param Request $request
     * @return string
     */
    public function convert(Request $request)
    {
        // $input = '355'; // Test input
        $input = 'MMMMCCCLV'; // Test input
        // $input = $request->input('input'); // Request input from the user
        
        // Check if the input is an integer or a Roman numeral
        if (is_numeric($input)) {
            $intValue = filter_var($input, FILTER_VALIDATE_INT); // Validate the input as an integer
            if ($intValue !== false) {
                // Input is a valid integer
                return $this->convertIntegerToRoman($intValue);
            } else {
                // Input is not an integer
                return response()->json(['error' => 'Input is not a valid integer.'], 400);
            }
        }
        return $this->convertRomanToInteger($input);
    }

    /**
     * Convert an integer to a Roman numeral.
     *
     * @param int $input
     * @return string
     */
    private function convertIntegerToRoman(int $input)
    {
        if ($input < 1 || $input > 100000) {
            // Integer is out of range
            return response()->json(['error' => 'Integer out of range. Please enter an integer between 1 and 100,000.'], 400);
        }

        $result = '';

        // Loop through the array of Roman numerals
        foreach ($this->romanNumerals as $symbol => $value) {
            // Repeat the Roman numeral while the input is greater than or equal to the value
            while ($input >= $value) {
                // echo "Roman: " .$symbol. " Input:". $input . ' ' . "Value:". $value .  PHP_EOL;
                $result .= $symbol; // Append the Roman numeral to the result
                $input -= $value; // Subtract the value from the input
            }
        }

        // Return the result as a JSON response
        return response()->json(['output' => $result]);
    }

    /**
     * Convert a Roman numeral to an integer.
     *
     * @param string $input
     * @return string
     */
    private function convertRomanToInteger(string $input)
    {
        // Check if the input is a valid Roman numeral
        if (!preg_match('/^(M{0,3})(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/', $input)) {
            return response()->json(['error' => 'Invalid Roman numeral. Please enter a valid Roman numeral.'], 400);
        }

        $result = 0; // Initialise the result to 0

        // Loop through the array of Roman numerals
        foreach ($this->romanNumerals as $symbol => $value) {
            // Repeat the Roman numeral while the input starts with the symbol
            while (strpos($input, $symbol) === 0) {
                $result += $value; // Add the value to the result
                $input = substr($input, strlen($symbol)); // Remove the symbol from the input
            }
        }

        // Return the result as a JSON response
        return response()->json(['output' => $result]);

    }
}

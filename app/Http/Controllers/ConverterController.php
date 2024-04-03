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
        $input = '355'; // Test input
        // $input = $request->input('input'); // Request input from the user
        
        // Check if the input is an integer or a Roman numeral
        if (is_numeric($input)) {
            $intValue = filter_var($input, FILTER_VALIDATE_INT); // Validate the input as an integer
            if ($intValue !== false) {
                // Input is a valid integer
                if ($intValue < 1 || $intValue > 100000) {
                    // Integer is out of range
                    return response()->json(['error' => 'Integer out of range. Please enter an integer between 1 and 100,000.'], 400);
                }
                return $this->convertIntegerToRoman($intValue);
            } else {
                // Input is not an integer
                return response()->json(['error' => 'Input is not a valid integer.'], 400);
            }
        }
        return $this->convertRomanToInteger($input);
    }

    private function convertIntegerToRoman(int $input)
    {
        dd("Valid Integer Inputs");
    }

    private function convertRomanToInteger(string $input)
    {
        dd($input);
    }
}

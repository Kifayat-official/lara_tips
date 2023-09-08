<?php

namespace App\Helpers;

class Utils
{
    public static function getDiscoNameByCode($disco_code)
    {
        // Check if $disco_code is not null and not empty
        if ($disco_code !== null && !empty($disco_code)) {
            // Trim spaces from the start and end of $disco_code
            $disco_code = trim($disco_code);

            $discoNames = [
                11 => 'LESCO',
                12 => 'GEPCO',
                13 => 'FESCO',
                14 => 'IESCO',
                15 => 'MEPCO',
                26 => 'PESCO',
                37 => 'HESCO',
                38 => 'SEPCO',
                48 => 'QESCO',
                59 => 'TESCO',
                // Add more disco codes and names as needed
            ];

            // Check if the provided disco code exists in the array
            if (array_key_exists($disco_code, $discoNames)) {
                return $discoNames[$disco_code];
            } else {
                // If the disco code is not found, return an appropriate message or handle the error as needed
                return 'Unknown Disco Code';
            }
        } else {
            // If $disco_code is null or empty, return an appropriate message or handle the error as needed
            return 'Invalid Disco Code';
        }
    }

    public static function cleanString($input)
    {
        // Remove HTML tags
        $cleanedString = strip_tags($input);

        // Convert special characters to HTML entities to prevent XSS attacks
        $cleanedString = htmlspecialchars($cleanedString, ENT_QUOTES, 'UTF-8');

        // Trim whitespace from the start and end of the string
        $cleanedString = trim($cleanedString);

        return $cleanedString;
    }
}

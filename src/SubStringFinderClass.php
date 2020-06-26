<?php

namespace SubStringFinder\src;

class SubStringFinderClass {

    public function __construct() {
        echo __CLASS__;
    }

    /**
     * @param string $substring
     * @param string $filepath
     *
     * Returns the line number and the substring position in the file. [numberLine, position]
     *
     * If the substring is not found, returns []
     *
     * The sequence number of the occurrence. By default, it searches for the first occurrence
     * @param int    $occurrenceNumber
     *
     * @return int[]
     */
    public static function findSubStringInFile(string $substring, string $filepath, int $occurrenceNumber = 1): array {

        $lineNumber = 1;
        foreach (self::readLines($filepath) as $line) {
            $substrPos = strpos($line, $substring);

            if($substrPos !== false ) {
                if($occurrenceNumber - 1 === 0){
                    return [$lineNumber, $substrPos];
                }

                $occurrenceNumber--;
            }
            $lineNumber++;
        }

        return [];
    }

    private static function readLines(string $filepath) {
        $handle = fopen($filepath, "r");

        while (! feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }

}

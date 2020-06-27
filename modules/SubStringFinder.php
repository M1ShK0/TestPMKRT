<?php

namespace SubStringFinder;

require __DIR__ . "/../config/config.php";
require __DIR__ . "/Validator.php";
require __DIR__ . "/FileLinesReader.php";

use Exception;
use Generator;
use SubStringFinder\config\config;
use SubStringFinder\modules\FileLinesReader;
use SubStringFinder\modules\Validator;

/**
 * Class SubStringFinder
 * @package SubStringFinder
 */
class SubStringFinder {

    /**
     * @var config
     */
    private $config;

    /**
     * SubStringFinder constructor.
     */
    public function __construct() {
        $this->config = new config();
    }


    /**
     * @param $config
     *
     * @return $this
     */
    public function setConfig($config) {
        $this->config = $config;

        return $this;
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
     * @throws Exception
     */
    public function findSubStringInFile(string $substring, string $filepath, int $occurrenceNumber = 1): array {

        $validator  = new Validator($this->config);
        $lineNumber = 1;
        $validator->validateFile($filepath);

        $linesReader = new FileLinesReader();

        foreach ($linesReader->readLines($filepath) as $line) {
            $substrPos = strpos($line, $substring);

            if ($substrPos !== false) {
                if ($occurrenceNumber - 1 === 0) {
                    return [$lineNumber, $substrPos];
                }

                $occurrenceNumber--;
            }
            $lineNumber++;
        }

        return [];
    }


    /**
     * @param string $substring
     * @param string $filepath
     *
     * Returns all line numbers and substring positions in a file. [ [numberLine, position], ... ]
     *
     * If the substring is not found, returns []
     *
     * @return int[]
     * @throws Exception
     */
    public function findAllSubStringInFile(string $substring, string $filepath): array {
        $linesReader = new FileLinesReader();
        $res         = [];
        $lineNumber  = 1;
        foreach ($linesReader->readLines($filepath) as $line) {
            $substrPos = strpos($line, $substring);

            if ($substrPos !== false) {
                $res[] = [$lineNumber, $substrPos];
            }

            $lineNumber++;
        }

        return $res;
    }


}

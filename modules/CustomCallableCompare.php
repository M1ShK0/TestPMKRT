<?php

namespace SubStringFinder;


use Exception;
use Config\config;

class CustomCallableCompare {

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
     * @param callable $callable
     * @param          $filepath
     *
     * The sequence number of the occurrence. By default, it searches for the first occurrence
     * @param int      $occurrenceNumber
     *
     *
     *
     * Returns the line number for callable.
     *
     * If not found, returns -1
     *
     * @return int
     * @throws Exception
     */
    public function findLine(callable $callable, $filepath, int $occurrenceNumber = 1): int {
        $validator  = new Validator($this->config);
        $lineNumber = 1;
        $validator->validateFile($filepath);

        $linesReader = new FileLinesReader();

        foreach ($linesReader->readLines($filepath) as $line) {
            if ($callable($line)) {
                if ($occurrenceNumber - 1 === 0) {
                    return $lineNumber;
                }

                $occurrenceNumber--;
            }
            $lineNumber++;
        }

        return -1;
    }
}
<?php

namespace SubStringFinder\modules;

use Generator;
use Exception;

final class FileLinesReader {

    /**
     * @param string $filepath
     *
     * @return Generator
     * @throws Exception
     */
    public function readLines(string $filepath) {


        $handle = fopen($filepath, "r");

        while (! feof($handle)) {
            yield trim(fgets($handle));
        }

        fclose($handle);
    }

}
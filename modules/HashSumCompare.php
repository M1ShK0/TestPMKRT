<?php

namespace SubStringFinder;

use Exception;
use Config\config;
use SubStringFinder\Validator;
use SubStringFinder\SubStringFinder;


class HashSumCompare {


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
     * @param string $filename
     * @param string $hash
     *
     * @return bool
     * @throws Exception
     */
    public function checkFile(string $filename, string $hash, string $algo = "md5") {
        $validator = new Validator($this->config);
        $validator->validateFile($filename);

        return $this->getHash($filename, $algo) == $hash;
    }

    /**
     * @param string $filename
     * @param string $algo
     *
     * @return string
     * @throws Exception
     */
    public function getHash(string $filename, string $algo = "md5") {
        $validator = new Validator($this->config);
        $validator->validateFile($filename);

        return hash_file($algo, $filename);
    }
}
<?php

namespace SubStringFinder\config;

use Symfony\Component\Yaml\Yaml;

class config {

    const DEFAULT_MAX_FILE_SIZE_ANY = 'any';
    const DEFAULT_MIME_TYPES_ANY    = [];

    public $maxFileSize = self::DEFAULT_MAX_FILE_SIZE_ANY; //default any
    public $mimeTypes   = self::DEFAULT_MIME_TYPES_ANY; //default any

    const PATH_TO_CONFIG_YAML = __DIR__ . '/../config.yaml';
    const MAX_FILE_SIZE_KEY   = 'maxFileSize';
    const MIME_TYPES_KEY      = 'mimeTypes';

    public function __construct() {
        $parsedYamlConfig = Yaml::parseFile(self::PATH_TO_CONFIG_YAML);

        if (
            isset($parsedYamlConfig[self::MAX_FILE_SIZE_KEY]) &&
            (
                $parsedYamlConfig[self::MAX_FILE_SIZE_KEY] === self::DEFAULT_MAX_FILE_SIZE_ANY ||
                is_int($parsedYamlConfig[self::MAX_FILE_SIZE_KEY])
            )
        ) {
            $this->maxFileSize = $parsedYamlConfig[self::MAX_FILE_SIZE_KEY];
        }

        if (
            isset($parsedYamlConfig[self::MIME_TYPES_KEY]) &&
            is_array($parsedYamlConfig[self::MIME_TYPES_KEY])
        ) {
            $this->mimeTypes = $parsedYamlConfig[self::MIME_TYPES_KEY];
        }
    }


}
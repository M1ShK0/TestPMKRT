<?php

namespace SubStringFinder;

use Config\config;
use Exception;


final class Validator {


    /**
     * @var config
     */
    private $config;

    /**
     * SubStringFinder constructor.
     *
     * @param config $config
     */
    public function __construct($config = null) {
        if (! $config) {
            $this->config = new config();
        } else {
            $this->config = $config;
        }
    }


    /**
     * @param $filepath
     *
     * @throws Exception
     */
    public function validateFile(string $filepath) {
        if ($this->config->maxFileSize !== config::DEFAULT_MAX_FILE_SIZE_ANY) {

            if (filter_var($filepath, FILTER_VALIDATE_URL)) {
                $data     = get_headers($filepath, 1);
                $filesize = isset($data['Content-Length']) ? (int) $data['Content-Length'] : -1;
            } else {
                $filesize = filesize($filepath);
            }

            if ($filesize == -1) {
                throw new Exception("Unable to determine file size");
            }

            if ($filesize > $this->config->maxFileSize)
                throw new Exception("File size cannot exceed " . $this->config->maxFileSize . " bytes");
        }

        if ($this->config->mimeTypes !== config::DEFAULT_MIME_TYPES_ANY) {
            if (filter_var($filepath, FILTER_VALIDATE_URL)) {
                $data     = get_headers($filepath, 1);
                $mimeType = isset($data['Content-Type']) ? $data['Content-Type'] : "";
                if (mb_strlen($mimeType) > 0 && strpos($mimeType, ';') !== false) {
                    $mimeType = explode(';', $mimeType)[0];
                }
            } else {
                $mimeType = mime_content_type($filepath);
            }


            if ($mimeType == "") {
                throw new Exception("Unable to determine file mimetype");
            }

            if (! in_array($mimeType, $this->config->mimeTypes)) {
                throw new Exception("Mime file type can only be: [ " . implode(', ', $this->config->mimeTypes) . " ]");
            }
        }
    }
}
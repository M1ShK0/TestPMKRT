<?php


namespace SubstringFinder\tests;

require __DIR__ . "/../modules/CustomCallableCompare.php";

use Exception;
use PHPUnit\Framework\TestCase;
use SubStringFinder\config\config;
use SubStringFinder\modules\CustomCallableCompare;
use SubStringFinder\modules\HashSumCompare;
use SubStringFinder\SubStringFinder;


class CustomCallableCompareTest extends TestCase {

    const FOLDER_FILES = '/files_for_testing';

    const FILE_NAME_TXT = __DIR__ . self::FOLDER_FILES . '/mor-uchenik-smerti-per-i-kravcova-pod-red-a-zhikarenceva_RuLit_Net_114846.txt';

    /**
     * @throws Exception
     */
    public function testCheckFileHash() {

        $customCallableCompare = new CustomCallableCompare();
        $config                = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $customCallableCompare->setConfig($config);


        $this->assertSame(
            4,
            $customCallableCompare->findLine(function ($line) {
                if (mb_strlen($line) > 40) {
                    return true;
                }
                return false;
            }, self::FILE_NAME_TXT)
        );
    }

}
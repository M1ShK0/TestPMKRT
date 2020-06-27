<?php
namespace Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Config\config;
use SubStringFinder\HashSumCompare;
use SubStringFinder\SubStringFinder;


class HashSumCompareTest extends TestCase {

    const FOLDER_FILES = '/files_for_testing';

    const FILE_NAME_TXT = __DIR__ . self::FOLDER_FILES . '/mor-uchenik-smerti-per-i-kravcova-pod-red-a-zhikarenceva_RuLit_Net_114846.txt';

    const REMOTE_FILE_NAME_TXT = 'https://spb.hh.ru/resume/35a4985fff0436d6360039ed1f377651424247';

    const HASH_FOR_TEST_SUCCESS = '6ac2204f408b17a5be6c6713f5ea367b';

    const HASH_FOR_TEST_UNSUCCESS = 'aaaaaaaaaaa';


    public function testCheckFileHash() {

        $hashSumCompare = new HashSumCompare();
        $config         = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $hashSumCompare->setConfig($config);


        $this->assertSame(
            true,
            $hashSumCompare->checkFile(self::FILE_NAME_TXT, self::HASH_FOR_TEST_SUCCESS)
        );
    }


    public function testCheckFileHashUnsuccess() {

        $hashSumCompare = new HashSumCompare();
        $config         = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $hashSumCompare->setConfig($config);


        $this->assertSame(
            false,
            $hashSumCompare->checkFile(self::FILE_NAME_TXT, self::HASH_FOR_TEST_UNSUCCESS)
        );
    }


    public function testCheckFileHashRemoteUnSuccess() {

        $hashSumCompare = new HashSumCompare();
        $config         = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $hashSumCompare->setConfig($config);

        $this->assertSame(
            false,
            $hashSumCompare->checkFile(self::REMOTE_FILE_NAME_TXT, self::HASH_FOR_TEST_UNSUCCESS)
        );
    }


}
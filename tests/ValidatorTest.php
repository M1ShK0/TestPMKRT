<?php

namespace SubstringFinder\tests;


use Exception;
use PHPUnit\Framework\TestCase;
use SubStringFinder\config\config;
use SubStringFinder\modules\SubStringFinder;

class ValidatorTest extends TestCase {


    const FOLDER_FILES = '/files_for_testing';

    const FILE_NAME_TXT        = __DIR__ . self::FOLDER_FILES . '/mor-uchenik-smerti-per-i-kravcova-pod-red-a-zhikarenceva_RuLit_Net_114846.txt';
    const REMOTE_FILE_NAME_TXT = 'https://spb.hh.ru/resume/35a4985fff0436d6360039ed1f377651424247';


    const SUBSTRING_FOR_FIND_SUCCESS         = 'Мор';
    const SUBSTRING_FOR_FIND_SUCCESS_REMOTE  = 'Web';


    const SUBSTRING_FOR_FIND_UNSUCCESS = 'sd2ddsdf324d';


    public function testUnSuccessFileSize() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = 1024;//bites
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $finder->setConfig($config);


        $this->expectException(Exception::class);
        $this->expectExceptionMessage("File size cannot exceed 1024 bytes");

        $finder->findSubStringInFile(
            self::SUBSTRING_FOR_FIND_UNSUCCESS,
            self::FILE_NAME_TXT
        );
    }



    public function testUnSuccessMimeType() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;//bites
        $config->mimeTypes   = ['application/pdf'];

        $finder->setConfig($config);


        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Mime file type can only be: [ application/pdf ]");

        $finder->findSubStringInFile(
            self::SUBSTRING_FOR_FIND_UNSUCCESS,
            self::FILE_NAME_TXT
        );
    }




    /**
     * @throws Exception
     */
    public function testSuccessMimeType() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;//bites
        $config->mimeTypes   = ['text/plain'];

        $finder->setConfig($config);


        $this->assertSame(
            [15, 0],
            $finder->findSubStringInFile(
                self::SUBSTRING_FOR_FIND_SUCCESS,
                self::FILE_NAME_TXT,
                2
            )
        );
    }


    public function testUnSuccessFileSizeRemoteFile() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = 1024;//bites
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $finder->setConfig($config);


        $this->expectException(Exception::class);
        $this->expectExceptionMessage("File size cannot exceed 1024 bytes");

        $finder->findSubStringInFile(
            self::SUBSTRING_FOR_FIND_SUCCESS_REMOTE,
            self::REMOTE_FILE_NAME_TXT
        );
    }

    public function testUnSuccessMimeTypeRemote() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;//bites
        $config->mimeTypes   = ['text/plain'];

        $finder->setConfig($config);


        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Mime file type can only be: [ text/plain ]");

        $finder->findSubStringInFile(
            self::SUBSTRING_FOR_FIND_UNSUCCESS,
            self::REMOTE_FILE_NAME_TXT
        );
    }

    public function testSuccessMimeTypeRemote() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;//bites
        $config->mimeTypes   = ['text/html'];

        $finder->setConfig($config);

        $this->assertSame(
            [2, 262],
            $finder->findSubStringInFile(
                self::SUBSTRING_FOR_FIND_SUCCESS_REMOTE,
                self::REMOTE_FILE_NAME_TXT
            )
        );
    }
}
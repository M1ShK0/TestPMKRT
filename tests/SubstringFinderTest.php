<?php
namespace Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Config\config;
use SubStringFinder\SubStringFinder;


class SubstringFinderTest extends TestCase {

    const FOLDER_FILES = '/files_for_testing';

    const FILE_NAME_TXT        = __DIR__ . self::FOLDER_FILES . '/mor-uchenik-smerti-per-i-kravcova-pod-red-a-zhikarenceva_RuLit_Net_114846.txt';
    const REMOTE_FILE_NAME_TXT = 'https://spb.hh.ru/resume/35a4985fff0436d6360039ed1f377651424247';


    const SUBSTRING_FOR_FIND_SUCCESS         = 'Мор';
    const SUBSTRING_FOR_FIND_SUCCESS_FOR_ALL = 'Х-м-м?';
    const SUBSTRING_FOR_FIND_SUCCESS_REMOTE  = 'Web';


    const SUBSTRING_FOR_FIND_UNSUCCESS = 'sd2ddsdf324d';

    public function testSuccessFindFirstSubString() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $finder->setConfig($config);


        $this->assertSame(
            [4, 29],
            $finder->findSubStringInFile(
                self::SUBSTRING_FOR_FIND_SUCCESS,
                self::FILE_NAME_TXT
            )
        );
    }


    public function testSuccessFindSecondSubString() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

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

    public function testUnSuccessFindSubString() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $finder->setConfig($config);

        $this->assertSame(
            [],
            $finder->findSubStringInFile(
                self::SUBSTRING_FOR_FIND_UNSUCCESS,
                self::FILE_NAME_TXT
            )
        );
    }


    /**
     * @throws Exception
     */
    public function testSuccessFindFirstSubStringRemoteFile() {

        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $finder->setConfig($config);


        $this->assertSame(
            [2, 262],
            $finder->findSubStringInFile(
                self::SUBSTRING_FOR_FIND_SUCCESS_REMOTE,
                self::REMOTE_FILE_NAME_TXT
            )
        );
    }


    public function testFindAll() {
        $finder = new SubStringFinder();

        $config = new config();

        $config->maxFileSize = config::DEFAULT_MAX_FILE_SIZE_ANY;
        $config->mimeTypes   = config::DEFAULT_MIME_TYPES_ANY;

        $finder->setConfig($config);


        $this->assertSame(
            [[355, 5], [366, 5]],
            $finder->findAllSubStringInFile(
                self::SUBSTRING_FOR_FIND_SUCCESS_FOR_ALL,
                self::FILE_NAME_TXT
            )
        );
    }


}

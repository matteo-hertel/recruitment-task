<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

use ThirdBridge\BusinessLogic\UsersLogic;
use ThirdBridge\CsvParser;
use \ThirdBridge\XmlParser;

define("APP_ROOT_KEY", "users");

class UsersFlowTest extends TestCase
{
    private $resultFile = __DIR__ . "/../../results/results.txt";

    private $expectedScore = 900;

    public function testUsersLogic()
    {

        $inst = new CsvParser();
        $inst->loadFile(__DIR__ . "/../../data/file.csv");

        $users = $inst->getContent();

        $logic = new UsersLogic();

        $logic->loadUsers($users);

        $this->assertSame($logic->getActiveScore(), $this->expectedScore);

        $logic->storeResult($this->resultFile, $logic->getActiveScore());

        $this->assertTrue(file_exists($this->resultFile));

        $this->assertEquals(file_get_contents($this->resultFile), $this->expectedScore);

        unlink($this->resultFile);
    }
}
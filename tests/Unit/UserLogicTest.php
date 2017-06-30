<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

use ThirdBridge\BusinessLogic\UsersLogic;

define("APP_ROOT_KEY", "users");

/**
 * Class UserLogicTest
 * @package Tests\Feature
 */
class UserLogicTest extends TestCase
{

    /**
     * Fixture to make tests consistent
     * @var array
     */
    private $userMock = [
        "users" => [
            [
                "name" => "John",
                "active" => "true",
                "value" => "500"
            ],
            [
                "name" => "Jane",
                "active" => "false",
                "value" => "500"
            ],
            [
                "name" => "Dave",
                "active" => "true",
                "value" => "500"
            ],
            [
                "name" => "Linus",
                "active" => "true",
                "value" => "1000"
            ],
            [
                "name" => "Bill",
                "active" => "false",
                "value" => "500"
            ]
        ]
    ];

    private $resultFile = __DIR__ . "/../../results/results.txt";

    private $expectedScore = 2000;

    /**
     * Testing load data and business logic
     */
    public function testUsersLogic()
    {

        $logic = new UsersLogic();

        $logic->loadUsers($this->userMock);

        $this->assertSame($logic->getActiveScore(), $this->expectedScore);

        $logic->storeResult($this->resultFile, $logic->getActiveScore());

        $this->assertTrue(file_exists($this->resultFile));

        $this->assertEquals(file_get_contents($this->resultFile), $this->expectedScore);

        unlink($this->resultFile);
    }
}

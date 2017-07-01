<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

use ThirdBridge\BusinessLogic\UsersLogic;
use ThirdBridge\CsvParser;
use \ThirdBridge\XmlParser;

define("APP_ROOT_KEY", "users");

/**
 * Class CliScriptTest
 * @package Tests\Feature
 */
class CliScriptTest extends TestCase
{
    /**
     * result file name
     * @var string
     */
    private $resultFile = "results/results.txt";

    /**
     * result file full path
     * @var string
     */
    private $resultFulPath = __DIR__ . "/../../results/results.txt";


    /**
     * expected score
     * @var int
     */
    private $expectedScore = 900;

    /**
     * test the symfony console script without output flag
     */
    public function testSymfonyCliScriptWithoutOutputFile()
    {

        $shellResult = shell_exec(__DIR__ . "/../../console.php script data/file.yml");

        $this->assertEquals(trim(preg_replace('/\s\s+/', '', $shellResult)), $this->expectedScore);
    }

    /**
     * test the symfony console script with output flag
     */
    public function testSymfonyCliScriptWithOutputFile()
    {

        shell_exec(sprintf(__DIR__ . "/../../console.php script --output='%s' data/file.yml",
            $this->resultFile));

        $this->assertTrue(file_exists($this->resultFulPath));


        $this->assertEquals(file_get_contents($this->resultFulPath), $this->expectedScore);

        unlink($this->resultFulPath);
    }

    /**
     * test the symfony console script with both flags
     */
    public function testSymfonyCliScriptWithOptions()
    {

        shell_exec(sprintf(__DIR__ . "/../../console.php script --output='%s' --input='data/file.yml'",
            $this->resultFile));

        $this->assertTrue(file_exists($this->resultFulPath));


        $this->assertEquals(file_get_contents($this->resultFulPath), $this->expectedScore);

        unlink($this->resultFulPath);
    }

    /**
     * test the custom  console script with single argument
     */
    public function testCustomCliScriptWithoutOutputFile()
    {

        $shellResult = shell_exec(__DIR__ . "/../../script.php data/file.yml");

        $this->assertEquals(trim(preg_replace('/\s\s+/', '', $shellResult)), $this->expectedScore);
    }


    /**
     * test the custom  console script with both flags
     */
    public function testCustomCliScriptWithOptions()
    {

        shell_exec(sprintf(__DIR__ . "/../../script.php --output='%s' --input='data/file.csv'",
            $this->resultFile));

        $this->assertTrue(file_exists($this->resultFulPath));


        $this->assertEquals(file_get_contents($this->resultFulPath), $this->expectedScore);

        unlink($this->resultFulPath);
    }
}
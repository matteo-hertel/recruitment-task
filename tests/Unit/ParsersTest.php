<?php


namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Tests\Util\ClassFinder;

define("APP_ROOT_KEY", "users");

/**
 * Class ParsersTest
 *
 * I want to try a different approach here, because all the parser have to behave the very same, rather than explicitly
 * test every single parser, I'll find the parsers in the given namespace and all of them will be automatically tested
 * the very same way, if a parser behaves correctly all the tests will be green, this will ensure consistent behaviour
 * and follow SOLID
 *
 * @package Tests\Unit
 */
class ParsersTest extends TestCase
{
    /**
     * define the parsers namespace
     */
    const PARSERS_NAMESPACE = "ThirdBridge";

    /**
     * main function for PHP unit
     * get the available parsers and test them
     */
    public function testParsers()
    {
        $parsers = $this->getParsers();

        array_map(function (string $parser) {
            $this->initParserTest($parser);
        }, $parsers);
    }

    /**
     * Test the given parser, the very same way as every other
     * @param string $parser
     */
    private function initParserTest(string $parser)
    {
        $type = $this->getParserType($parser);

        $inst = new $parser();
        $inst->loadFile(__DIR__ . "/../../data/file." . $type);

        $this->assertTrue(is_array($inst->getContent()));
        $this->assertTrue(is_array($inst->getContent()["users"]));
        $this->assertSame(count($inst->getContent()["users"]), 4);


    }

    /**
     * Use a util class to peak in the namespace and get the declared classes and return only the parsers
     *
     * @return array
     */
    private function getParsers(): array
    {
        $classes = ClassFinder::getClassesInNamespace(self::PARSERS_NAMESPACE);
        return array_filter($classes, function (string $className): bool {
            return substr($className, -6) === "Parser";
        });
    }

    /**
     * Extract the type so a different file will be give to the loadFile
     *
     * @param string $parser
     * @return string
     */
    private function getParserType(string $parser): string
    {
        $parser = str_replace(self::PARSERS_NAMESPACE . "\\", "", $parser);
        return strtolower(str_replace("Parser", "", $parser));
    }
}

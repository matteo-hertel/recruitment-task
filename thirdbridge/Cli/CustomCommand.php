<?php

namespace ThirdBridge\Cli;

use \ThirdBridge\BusinessLogic\UsersLogic;

/**
 * Class CustomCommand
 *
 * Because using the console component doest give an interface that matches 100% the requirements
 * this will provide exactly what's asked in the requirement, it will cover the basics but it's not a well tested
 * package like the Symfony console component
 *
 * @package ThirdBridge\Cli
 */
class CustomCommand
{

    /**
     * @param $rawArguments
     */
    public static function execute($rawArguments)
    {
        array_shift($rawArguments);

        if (count($rawArguments) === 1) {
            return static::cli($rawArguments[0], false);
        }
        $arguments = [];
        foreach ($rawArguments as $arg) {
            $output_array = [];
            preg_match("/--(\w+)=(.+\w)/", $arg, $output_array);
            $arguments[$output_array[1]] = $output_array[2];
        }
        return static::cli($arguments["input"], $arguments["output"]);
    }


    /**
     * Very same logic as the Symfony command
     *
     * @param $inputFile
     * @param $outputFile
     */
    private static function cli($inputFile, $outputFile)
    {
        try {

            $parserType = pathinfo($inputFile)["extension"];
            $class = sprintf("\ThirdBridge\%sParser", ucfirst($parserType));
            if (!class_exists($class)) {
                throw new Exception("Missing Parser");
            }

            $inst = new $class();
            $inst->loadFile(__DIR__ . "/../../$inputFile");

            $users = $inst->getContent();

            $logic = new UsersLogic();

            $logic->loadUsers($users);

            if (!$outputFile) {
                echo $logic->getActiveScore() . "\n";
                return;
            }

            $logic->storeResult(__DIR__ . "/../../$outputFile", $logic->getActiveScore());


        } catch (\Exception $exc) {
            echo 'An error occurred';
        }
    }

}
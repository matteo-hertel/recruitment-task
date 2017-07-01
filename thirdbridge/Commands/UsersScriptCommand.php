<?php

namespace ThirdBridge\Commands;

use PHPUnit\Runner\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use \ThirdBridge\BusinessLogic\UsersLogic;
use ThirdBridge\Interfaces\FileParserInterface;

/**
 * Class UsersScriptCommand
 * @package ThirdBridge\Commands
 */
class UsersScriptCommand extends Command
{
    /**
     * configure the CLI command
     */
    protected function configure()
    {
        $this
            ->setName('script')
            ->setDescription('Execute the script')
            ->setHelp('You always has to pass 1 or 2 parameters - input and optionally output')
            ->addOption('input', null, InputArgument::OPTIONAL, 'Input file (override argument')
            ->addOption('output', null, InputArgument::OPTIONAL, 'Output file')
            ->addArgument('input', InputArgument::OPTIONAL, 'Input file');;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $inputFile = $input->getOption('input') ? $input->getOption('input') : $input->getArgument('input');
            $outputFile = $input->getOption('output');

            $parserType = pathinfo($inputFile)["extension"];
            $class = sprintf("\ThirdBridge\%sParser", ucfirst($parserType));
            if (!class_exists($class)) {
                throw new Exception("Missing Parser");
            }

            $reflection = new \ReflectionClass($class);
            if (!$reflection->implementsInterface(FileParserInterface::class)) {
                throw new Exception("Invalid Parser");
            }

            $inst = new $class();
            $inst->loadFile(__DIR__ . "/../..//$inputFile");

            $users = $inst->getContent();

            $logic = new UsersLogic();

            $logic->loadUsers($users);

            if (!$outputFile) {
                $output->writeln($logic->getActiveScore());
                return;
            }

            $logic->storeResult(__DIR__ . "/../../$outputFile", $logic->getActiveScore());


        } catch (\Exception $exc) {
            $output->writeln('An error occurred');
        }


    }
}

<?php

namespace ThirdBridge;

/**
 * Class CsvParser
 * @package ThirdBridge
 */
class CsvParser implements Interfaces\FileParserInterface
{
    /**
     * @var string
     */
    private $rootKey = "root";
    /**
     * @var array
     */
    private $data = [];

    /**
     * CsvParser constructor.
     */
    public function __construct()
    {
        $this->rootKey = APP_ROOT_KEY;
    }

    /**
     * @param string $filePath
     * @return void
     */
    public function loadFile(string $filePath)
    {
        $handle = fopen($filePath, "r");

        for ($i = 0; $row = fgetcsv($handle); ++$i) {
            $this->data[$this->rootKey][] = $row;
        }

        fclose($handle);
    }

    /**
     * @return array from data property
     */
    public function getContent(): array
    {
        return $this->data;
    }
}

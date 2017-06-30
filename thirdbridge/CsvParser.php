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
     * @var array
     */
    private $keys = [];

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
            if (!$i) { // skip heading
                $this->keys = $row;
                continue;
            }
            $this->data[$this->rootKey][] = array_combine($this->keys, $row);
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

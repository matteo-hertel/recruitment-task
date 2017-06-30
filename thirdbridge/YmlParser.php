<?php

namespace ThirdBridge;

use Symfony\Component\Yaml\Yaml;

/**
 * Class YmlParser
 * @package ThirdBridge
 */
class YmlParser implements Interfaces\FileParserInterface
{
    /**
     * @var array
     */
    private $data = [];


    /**
     * @param string $filePath
     * @return void
     */
    public function loadFile(string $filePath)
    {
        $this->data = Yaml::parse(file_get_contents($filePath));
    }

    /**
     * @return array from data property
     */
    public function getContent(): array
    {
        return $this->data;
    }
}

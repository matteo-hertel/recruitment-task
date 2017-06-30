<?php

namespace ThirdBridge\Interfaces;


/**
 * Interface FileParserInterface
 * @package ThirdBridge\Interfaces
 */
interface FileParserInterface
{
    /**
     * @param string $filePath
     * @return array
     */
    public function loadFile(string $filePath);

    /**
     * @return array
     */
    public function getContent(): array;
}
<?php

namespace ThirdBridge;


/**
 * Class XmlParser
 * @package ThirdBridge
 */
class XmlParser implements Interfaces\FileParserInterface
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
     * XmlParser constructor.
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
        $iterator = new \SimpleXmlIterator($filePath, null, true);
        $this->data = [$this->rootKey => array_pop($this->iteratorToArray($iterator))];
    }

    /**
     * @return array from data property
     */
    public function getContent(): array
    {
        return $this->data;
    }

    /**
     * @param $iterator \SimpleXmlIterator
     * @return array
     */
    public function iteratorToArray(\SimpleXmlIterator $iterator)
    {
        $a = array();
        for ($iterator->rewind(); $iterator->valid(); $iterator->next()) {
            if (!array_key_exists($iterator->key(), $a)) {
                $a[$iterator->key()] = array();
            }
            if ($iterator->hasChildren()) {
                $a[$iterator->key()][] = $this->iteratorToArray($iterator->current());
            } else {
                $a[$iterator->key()] = strval($iterator->current());
            }
        }

        return $a;
    }
}

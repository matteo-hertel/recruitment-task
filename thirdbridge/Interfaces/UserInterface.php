<?php

namespace ThirdBridge\Interfaces;


/**
 * Interface UserInterface
 * @package ThirdBridge\Interfaces
 */
interface UserInterface
{

    /**
     * @return int
     */
    public function getValue(): int;

    /**
     * @return bool
     */
    public function isActive(): bool;
}
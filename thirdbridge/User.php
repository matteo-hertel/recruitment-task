<?php

namespace ThirdBridge;

/**
 * Class User
 * @package ThirdBridge
 */
class User implements Interfaces\UserInterface
{

    /**
     * @var object
     */
    private $user;

    /**
     * User constructor.
     * @param array $user
     */
    public function __construct(array $user)
    {
        $this->user = (object)$user;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return (int)$this->user->value;
    }

    /**
     * add the filter war to handle strings like "false"
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return filter_var($this->user->active, FILTER_VALIDATE_BOOLEAN);
    }
}

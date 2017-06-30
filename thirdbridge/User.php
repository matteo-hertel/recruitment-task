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
        return $this->user->value;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->user->active;
    }
}

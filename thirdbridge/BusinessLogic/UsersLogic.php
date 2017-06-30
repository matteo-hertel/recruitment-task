<?php

namespace ThirdBridge\BusinessLogic;

use ThirdBridge\User;

/**
 * Class UsersLogic
 * @package ThirdBridge\BusinessLogic
 */
class UsersLogic
{
    /**
     * internal users list
     * @var
     */
    private $users = [];

    /**
     * gets an array in and creates an instance of User for each element
     * in the users array
     * @param array $users
     */
    public function loadUsers(array $users)
    {
        $this->users = array_map(function ($item) {
            return new User($item);
        }, $users["users"]);
    }

    /**
     * get the score of all the active users
     *
     * @return int
     */
    public function getActiveScore(): int
    {

        return array_reduce($this->users, function (int $acc, User $item): int {
            if (!$item->isActive()) {
                return $acc;
            }
            return $acc += $item->getValue();
        }, 0);

    }

    /**
     *
     * store given result to given path
     *
     * @param string $path
     * @param int $result
     * @return bool
     */
    public function storeResult(string $path, int $result): bool
    {
        $file = new \SplFileObject($path, "w");
        $file->fwrite($result);

        return true;
    }
}
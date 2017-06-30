<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use ThirdBridge\User;
use ThirdBridge\Interfaces\UserInterface;


/**
 * Class UserTest
 * @package Tests\Unit
 */
class UserTest extends TestCase
{
    // mock object would be better here but for such small scale this is more than enough
    /**
     * Active user fixtures, note active as string
     */
    const ACTIVE_USER_FIXTURE = ["name" => "John", "active" => "true", "value" => 500];
    /**
     * Inactive user fixtures, note value as string
     */
    const INACTIVE_USER_FIXTURE = ["name" => "Jane", "active" => false, "value" => "800"];


    /**
     * A LOT is happening here:
     *
     * By testing if the User class implements the interface UserInterface we're testing:
     *
     * - the class implements the interface
     * - the type checking in the function signature and return type are matching in the class
     * - we're following SOLID principles
     *
     * @return void
     */
    public function testImplementsInterface()
    {
        $this->assertInstanceOf(UserInterface::class, new User(self::ACTIVE_USER_FIXTURE));
    }

    /**
     * Because PHP7 introduced scalar types and return type the return value of a function
     * if the return type is declared will cast the result to the given type
     * that makes our life easier while testing (as long as we remember that a type cast is happening)
     * for instance in active user fixture the active property will be a string and PHPUnit
     * assert true expects a boolean, the correct value will be returned from the function because
     * of return type
     *
     * @return void
     */
    public function testIsUserActive()
    {
        $activeUser = new User(self::ACTIVE_USER_FIXTURE);
        $inactiveUser = new User(self::INACTIVE_USER_FIXTURE);

        $this->assertTrue($activeUser->isActive());
        $this->assertFalse($inactiveUser->isActive());
    }

    /**
     * Check return type note above
     *
     * note for the asserSame, the value from the fixture is casted as int to check the return type
     * asserEqual could do the same but there won't be difference between "1" and 1
     *
     * @return void
     */
    public function testGetValue()
    {
        //code repetition in tests is perfectly fine
        $activeUser = new User(self::ACTIVE_USER_FIXTURE);
        $inactiveUser = new User(self::INACTIVE_USER_FIXTURE);

        $this->assertInternalType("int", $activeUser->getValue());
        $this->assertSame((int)self::ACTIVE_USER_FIXTURE["value"], $activeUser->getValue());

        $this->assertInternalType("int", $inactiveUser->getValue());
        $this->assertSame((int)self::INACTIVE_USER_FIXTURE["value"], $inactiveUser->getValue());

    }
}

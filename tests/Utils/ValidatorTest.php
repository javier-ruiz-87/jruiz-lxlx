<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 11:17
 */
declare(strict_types=1);

namespace App\Tests\Utils;

use App\Utils\Validator;
use PHPUnit\Framework\TestCase;

/**
 * Class ValidatorTest
 */
class ValidatorTest extends TestCase
{
    private $object;

    public function __construct()
    {
        parent::__construct();

        $this->object = new Validator();
    }

    public function testValidateEmail()
    {
        $test = '@';

        $this->assertSame($test, $this->object->validateEmail($test));
    }

    public function testValidateEmailEmpty()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The email can not be empty.');
        $this->object->validateEmail(null);
    }

    public function testValidateEmailInvalid()
    {
        $this->expectException('Exception');
        $this->expectExceptionMessage('The email should look like a real email.');
        $this->object->validateEmail('invalid');
    }
}
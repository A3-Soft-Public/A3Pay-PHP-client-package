<?php

namespace A3Soft\A3PayPhpClient\Tests\Utils;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Exception\VariableNotGuidException;
use A3Soft\A3PayPhpClient\Exception\VariableNotUrlException;
use A3Soft\A3PayPhpClient\Util\Utils;
use PHPUnit\Framework\TestCase;

/**
 * @package Test
 */
class UtilsTest extends TestCase
{
    public string $text = "123456789"; //9 chars

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableMaxLenException()
    {
        $this->expectException(VariableLengthException::class);
        Utils::CheckVariableLen($this->text, 'text', strlen($this->text) - 1);
    }


    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableMaxLen()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckVariableLen($this->text, 'text', strlen($this->text));
    }

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableMinLenException()
    {
        $this->expectException(VariableLengthException::class);
        Utils::CheckVariableLen($this->text, 'text', null, false, strlen($this->text) + 1);
    }

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableMinLen()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckVariableLen($this->text, 'text', null, false, strlen($this->text));
    }

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableMinMaxLenException()
    {
        $this->expectException(VariableLengthException::class);
        Utils::CheckVariableLen($this->text, 'text', strlen($this->text) - 1, false, strlen($this->text));
    }

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableMinMaxLen()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckVariableLen($this->text, 'text', strlen($this->text), false, strlen($this->text));
    }

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableLenNull()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckVariableLen(null, 'text', strlen($this->text) - 1, true, strlen($this->text) + 1);
    }


    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableLenInt()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckVariableLen(12, 'text', 2, true, 1);
    }


    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableLenIntMaxException()
    {
        $this->expectException(VariableLengthException::class);
        Utils::CheckVariableLen(12, 'text', 1, true, 1);

    }

    /**
     * @covers \A3Soft\A3PayPhpClient\Util\Utils::CheckVariableLen
     */
    public function testCheckVariableLenIntMinException()
    {
        $this->expectException(VariableLengthException::class);
        Utils::CheckVariableLen(12, 'text', 4, false, 3);

    }

    public function testCheckValueContainsArgsException()
    {
        $this->expectException(VariableNotContainsException::class);
        Utils::CheckValueContainsArgs('E', 'E', 'Y', 'N');
    }

    public function testCheckValueContainsException()
    {
        $this->expectException(VariableNotContainsException::class);
        Utils::CheckValueContains('E', 'E', ['Y', 'N']);
    }

    public function testCheckValueContainsArgs()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckValueContainsArgs('Y', 'Y', 'Y', 'N');
    }

    public function testCheckValueContains()
    {
        $this->expectNotToPerformAssertions();
        Utils::CheckValueContains('Y', 'Y', ['Y', 'N']);
    }

    public function testCheckValueGuidException()
    {
        $guid = 'A98C5A1E-A742-4808-96FA-6F409E7999';
        $this->expectException(VariableNotGuidException::class);
        Utils::CheckValueGuid($guid, 'guid');
    }
    public function testCheckValueGuid()
    {
        $guid = 'a98C5A1E-a742-48c8-96fA-6F409e799937';
        $guidBrackets = '{A98C5A1E-A742-4808-96FA-6F409E799937}';
        $this->expectNotToPerformAssertions();
        Utils::CheckValueGuid($guid, 'guid');
        Utils::CheckValueGuid($guidBrackets, 'guidBrackets');
    }

    public function testCheckValueUrl()
    {
        $this->expectNotToPerformAssertions();
        $url = 'https://example.com';
        Utils::CheckValueUrl($url, 'url');
    }

    public function testCheckValueUrlException()
    {
        $this->expectException(VariableNotUrlException::class);
        $url = 'a';
        Utils::CheckValueUrl($url, 'url');
    }
}
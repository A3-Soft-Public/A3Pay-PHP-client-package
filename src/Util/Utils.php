<?php
declare(strict_types=1);
namespace A3Soft\A3PayPhpClient\Util;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableNotContainsException;
use A3Soft\A3PayPhpClient\Exception\VariableNotGuidException;
use A3Soft\A3PayPhpClient\Exception\VariableNotUrlException;

/**
 * Utils class
 * @package Util
 */
class Utils
{
    /**
     * Checks for range of minimum or maximum length of characters / number
     * @param string|null|int $value
     * @param string $varName
     * @param int|null $maxLen
     * @param bool $checkIfNull
     * @param int|null $minLen
     * @return void
     * @throws VariableLengthException
     */
    public static function checkVariableLen($value, string $varName, ?int $maxLen = null, bool $checkIfNull = false, ?int $minLen = null)
    {
        if(gettype($value) === 'integer')
            $value = (string)$value;
        $throw = false;
        if($checkIfNull && $value === null)
            return;
        if($minLen !== null && $maxLen !== null) {
            if(strlen($value) < $minLen || strlen($value) > $maxLen)
                $throw = true;
        } elseif ($minLen !== null) {
            if(strlen($value) < $minLen)
                $throw = true;
        } else {
            if(strlen($value) > $maxLen)
                $throw = true;
        }

        if($throw)
            throw new VariableLengthException($varName, $maxLen, $minLen);
    }


    /**
     * Checks value if is one of contains parameter values
     * @param $value
     * @param string $varName
     * @param ...$contains
     * @return void
     * @throws VariableNotContainsException
     */
    public static function checkValueContainsArgs($value, string $varName, ...$contains)
    {
        Utils::checkValueContains($value, $varName, $contains);
    }

    /**
     * Checks value if is one of array value
     * @param $value
     * @param string $varName
     * @param array $contains
     * @return void
     * @throws VariableNotContainsException
     */
    public static function checkValueContains($value, string $varName, array $contains)
    {
        if(!in_array($value, $contains)) {
            throw new VariableNotContainsException($value, $varName, $contains);
        }
    }


    /**
     * Checks if value is Guid
     * @param $value
     * @param string $varName
     * @return void
     * @throws VariableNotGuidException
     */
    public static function checkValueGuid($value, string $varName)
    {
        if (!preg_match('/^\{?[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}\}?$/', $value)) {
            throw new VariableNotGuidException($value, $varName);
        }
    }

    /**
     * Checks if value match Url structure
     * @param $value
     * @param string $varName
     * @return void
     * @throws VariableNotUrlException
     */
    public static function checkValueUrl($value, string $varName)
    {
        if(filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new VariableNotUrlException($value, $varName);
        }
    }
}
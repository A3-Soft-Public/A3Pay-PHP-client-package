<?php
declare(strict_types=1);

namespace A3Soft\A3PayPhpClient\Util;

use A3Soft\A3PayPhpClient\Exception\VariableLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableMaxLengthException;
use A3Soft\A3PayPhpClient\Exception\VariableMinLengthException;
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
     * @throws VariableMinLengthException
     * @throws VariableMaxLengthException
     */
    public static function CheckVariableLen($value, string $varName, ?int $maxLen = null, bool $checkIfNull = false, ?int $minLen = null)
    {
        if (gettype($value) === 'integer')
            $value = (string)$value;

        if ($checkIfNull && $value === null)
            return;

        if ($minLen !== null && $minLen > strlen($value)) {
            throw new VariableMinLengthException($varName, $minLen);
        }

        if ($maxLen !== null && strlen($value) > $maxLen) {
            throw new VariableMaxLengthException($varName, $maxLen);
        }
    }

    /**
     * @param string|null $value
     * @param string $varName
     * @param int|null $maxLen
     * @param bool $checkIfNull
     * @param int|null $minLen
     * @throws VariableMinLengthException
     * @return void
     */
    public static function ClearAndTruncateVariableLen(?string &$value, string $varName, ?int $maxLen = null, bool $checkIfNull = false, ?int $minLen = null): void
    {
        if($value == null)
            return;

        $value = self::ClearAndTruncateText($value, $maxLen);
        try {
            static::CheckVariableLen($value, $varName, $maxLen, $checkIfNull, $minLen);
        }catch (VariableMaxLengthException $maxLengthException) {}
    }

    public static function ClearAndTruncateText(string $text, int $maxLength): string
    {
        $text = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $text);

        // Remove all other HTML tags
        $text = strip_tags($text);

        // Remove double spaces
        $text = preg_replace('/\s+/', ' ', $text);
        $text = trim($text);

        // Truncate the text if it exceeds the specified length
        if (strlen($text) > $maxLength) {
            $text = substr($text, 0, $maxLength - 3) . '...';
        }

        return $text;
    }


    /**
     * Checks value if is one of contains parameter values
     * @param $value
     * @param string $varName
     * @param ...$contains
     * @return void
     * @throws VariableNotContainsException
     */
    public static function CheckValueContainsArgs($value, string $varName, ...$contains): void
    {
        Utils::CheckValueContains($value, $varName, $contains);
    }

    /**
     * Checks value if is one of array value
     * @param $value
     * @param string $varName
     * @param array $contains
     * @return void
     * @throws VariableNotContainsException
     */
    public static function CheckValueContains($value, string $varName, array $contains): void
    {
        if (!in_array($value, $contains)) {
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
    public static function CheckValueGuid($value, string $varName): void
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
     * @throws VariableLengthException
     */
    public static function CheckValueUrl($value, string $varName, ?int $minLength = null, ?int $maxLength = null): void
    {
        if ($minLength !== null || $maxLength !== null) {
            $varLen = strlen($value);
            if ($varLen < $minLength || $varLen > $maxLength) {
                throw new VariableLengthException($varName, $minLength, $maxLength);
            }
        }
        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            throw new VariableNotUrlException($value, $varName);
        }
    }
}
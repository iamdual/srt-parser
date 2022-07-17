<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class Utils
{
    public static function formatNewLine(string $content): string {
        $content = str_replace("\r\n", "\n", $content);
        $content = str_replace("\r", "\n", $content);
        return $content;
    }

    public static function isNewLine(string $char): bool
    {
        return $char == "\n" || $char == "\r";
    }
}
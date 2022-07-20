<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtParser
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class Time
{
    private int $begin;
    private int $end;

    /** @var int $begin Begin of time in milliseconds */
    /** @var int $end End of time in milliseconds */
    public function __construct(int $begin, int $end)
    {
        $this->begin = $begin;
        $this->end = $end;
    }

    /** Begin of time in milliseconds */
    public function getBegin(): int
    {
        return $this->begin;
    }

    /** End of time in milliseconds */
    public function getEnd(): int
    {
        return $this->end;
    }
}
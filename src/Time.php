<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class Time
{
    /** @var int $begin Begin of time in milliseconds */
    private int $begin;

    /** @var int $end End of time in milliseconds */
    private int $end;

    public function __construct(int $begin, int $end)
    {
        $this->begin = $begin;
        $this->end = $end;
    }

    /**
     * @return int
     */
    public function getBegin(): int
    {
        return $this->begin;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }
}
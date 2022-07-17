<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class Subtitle
{
    /** @var int $sequence Sequence time of the subtitle */
    private int $sequence;

    /** @var int $time_begin Begin of time in milliseconds */
    private int $time_begin;

    /** @var int $time_end End of time in milliseconds */
    private int $time_end;

    /** @var string $content Subtitle content */
    private string $content;

    public function setSequence(string|int $sequence): self
    {
        $this->sequence = (int)$sequence;
        return $this;
    }

    public function setTimeBegin(string|int $time): self
    {
        $this->time_begin = (int)$time;
        return $this;
    }

    public function setTimeEnd(string|int $time): self
    {
        $this->time_end = (int)$time;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getSequence(): int
    {
        return $this->sequence;
    }

    public function getTimeBegin(): int
    {
        return $this->time_begin;
    }

    public function getTimeEnd(): int
    {
        return $this->time_end;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
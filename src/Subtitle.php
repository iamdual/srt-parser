<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class Subtitle
{
    private int $sequence;
    private int $time_begin;
    private int $time_end;
    private string $content;

    /** @var string|int $sequence Sequence number of the subtitle */
    public function setSequence(string|int $sequence): self
    {
        $this->sequence = (int)$sequence;
        return $this;
    }

    /** @var string|int $time Begin of time in milliseconds */
    public function setTimeBegin(string|int $time): self
    {
        $this->time_begin = (int)$time;
        return $this;
    }

    /** @var string|int $time End of time in milliseconds */
    public function setTimeEnd(string|int $time): self
    {
        $this->time_end = (int)$time;
        return $this;
    }

    /** @var string $content Subtitle content */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /** Sequence number of the subtitle */
    public function getSequence(): int
    {
        return $this->sequence;
    }

    /** Begin of time in milliseconds */
    public function getTimeBegin(): int
    {
        return $this->time_begin;
    }

    /** End of time in milliseconds */
    public function getTimeEnd(): int
    {
        return $this->time_end;
    }

    /** Subtitle content */
    public function getContent(): string
    {
        return $this->content;
    }
}
<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */

use Iamdual\SrtParser\Exceptions\SyntaxErrorException;

class TimeParser
{
    const TIME_FORMAT = '/^(\d{2,}):(\d{2}):(\d{2}),(\d{3})$/';

    private string $time;

    /** @var string $time SRT time (i.e. 00:00:01,100 --> 00:00:04,200) */
    public function __construct(string $time)
    {
        $this->time = $time;
    }

    /**
     * @return Time Parse SRT time and convert it into a Time
     * @throws SyntaxErrorException
     */
    public function getTime(): Time
    {
        $split_range = explode('-->', $this->time, 2);
        if (empty($split_range[1])) {
            throw new SyntaxErrorException('Invalid time range');
        }

        $raw_begin = trim($split_range[0]);
        $raw_end = trim($split_range[1]);
        $v_begin = preg_match(self::TIME_FORMAT, $raw_begin, $m_begin);
        $v_end = preg_match(self::TIME_FORMAT, $raw_end, $m_end);
        if (empty($v_begin) || empty($v_end)) {
            throw new SyntaxErrorException('Invalid time format');
        }

        $begin = self::toMilliseconds((int)$m_begin[1], (int)$m_begin[2], (int)$m_begin[3], (int)$m_begin[4]);
        $end = self::toMilliseconds((int)$m_end[1], (int)$m_end[2], (int)$m_end[3], (int)$m_end[4]);

        return new Time($begin, $end);
    }

    /** Calculate time in milliseconds */
    public static function toMilliseconds(int $hours, int $minutes, int $seconds, int $milliseconds): int
    {
        return ($hours * 60 * 60 * 1000) +
            ($minutes * 60 * 1000) +
            ($seconds * 1000) + $milliseconds;
    }
}
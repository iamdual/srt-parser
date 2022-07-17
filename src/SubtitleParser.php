<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */

use Iamdual\SrtParser\Exceptions\SyntaxErrorException;

class SubtitleParser
{
    const PART_SEQUENCE = 1;
    const PART_TIME = 2;
    const PART_CONTENT = 3;

    private string $chunk;
    private int $chunk_length;

    public function __construct(string $chunk)
    {
        $this->chunk = $chunk;
        $this->chunk_length = strlen($this->chunk);
    }

    /**
     * @throws SyntaxErrorException
     */
    public function getSubtitle(): Subtitle
    {
        $i = 0;
        $collector = '';
        $type = self::PART_SEQUENCE;
        $parts = [];

        while (isset($this->chunk[$i])) {
            $char = $this->chunk[$i];
            $collector .= $char;
            $is_latest_char = $this->chunk_length == ($i + 1);

            if (Utils::isNewLine($char) || $is_latest_char) {
                $collector = trim($collector);
                if ($collector !== '') {
                    $parts[$type] = $collector;

                    if ($type === self::PART_CONTENT) {
                        $collector = $collector . PHP_EOL;
                    } else {
                        $collector = '';
                    }

                    $type = match ($type) {
                        self::PART_SEQUENCE => self::PART_TIME,
                        default => self::PART_CONTENT,
                    };
                }
            }

            $i++;
        }

        if (isset($parts[self::PART_SEQUENCE], $parts[self::PART_TIME], $parts[self::PART_CONTENT])) {
            $timeParser = new TimeParser($parts[self::PART_TIME]);
            $time = $timeParser->getTime();

            $subtitle = new Subtitle();
            return $subtitle->setSequence($parts[self::PART_SEQUENCE])
                ->setTimeBegin($time->getBegin())
                ->setTimeEnd($time->getEnd())
                ->setContent($parts[self::PART_CONTENT]);
        }

        throw new SyntaxErrorException('There are missing parts');
    }
}
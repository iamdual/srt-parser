<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtParser
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class Generator
{
    private iterable $subtitles;

    /** @var Subtitle[] $subtitles */
    public function __construct(iterable $subtitles)
    {
        $this->subtitles = $subtitles;
    }

    /**
     * @return string
     */
    public function getOutput(): string
    {
        $output = $break = '';
        foreach ($this->subtitles as $subtitle) {
            $output .= $break;
            $break = PHP_EOL . PHP_EOL;

            $output .= $subtitle->getSequence();
            $output .= PHP_EOL;
            $output .= TimeParser::toSrtFormat($subtitle->getTimeBegin());
            $output .= ' --> ';
            $output .= TimeParser::toSrtFormat($subtitle->getTimeEnd());
            $output .= PHP_EOL;
            $output .= $subtitle->getContent();
        }
        return $output;
    }
}
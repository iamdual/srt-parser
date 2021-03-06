<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtParser
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srt-parser
 */
class SrtParser
{
    private string $content;

    /** @var string $content SRT file content */
    public function __construct(string $content)
    {
        $this->content = $content;
    }

    /** Create SrtParser instance by a file */
    public static function fromFile(string $filename): self
    {
        $content = file_get_contents($filename);
        return new self($content);
    }

    /**
     * @return Subtitle[]
     * @throws Exceptions\SyntaxErrorException
     */
    public function getSubtitles(): iterable
    {
        $subtitles = [];
        $chunks = new Chunks($this->content);
        foreach ($chunks->getChunks() as $chunk) {
            $parser = new SubtitleParser($chunk);
            $subtitles[] = $parser->getSubtitle();
        }
        return $subtitles;
    }
}
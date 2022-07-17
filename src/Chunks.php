<?php namespace Iamdual\SrtParser;
/**
 * @package Iamdual\SrtShifter
 * @license Apache License 2.0
 * @link    https://github.com/iamdual/srtparser
 */
class Chunks
{
    private string $content;
    private int $content_length;

    public function __construct(string $content)
    {
        $this->content = Utils::formatNewLine($content);
        $this->content_length = strlen($this->content);
    }

    public function getChunks(): array
    {
        $chunks = [];

        $i = 0;
        $nl_count = 0;
        $collector = '';

        while (isset($this->content[$i])) {
            $char = $this->content[$i];
            $collector .= $char;
            $is_latest_char = $this->content_length == ($i + 1);

            if (Utils::isNewLine($char) || $is_latest_char) {
                if ($nl_count >= 1 || $is_latest_char) {
                    $collector = trim($collector);
                    if ($collector !== '') {
                        $chunks[] = $collector;
                        $collector = '';
                    }
                }
                $nl_count++;
            } else {
                $nl_count = 0;
            }

            $i++;
        }
        return $chunks;
    }
}